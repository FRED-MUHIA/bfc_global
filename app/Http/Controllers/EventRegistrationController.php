<?php

namespace App\Http\Controllers;

use App\Mail\EventRegistrationSubmitted;
use App\Models\EventRegistration;
use App\Models\SiteSetting;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class EventRegistrationController extends Controller
{
    public function create(Request $request): View
    {
        $event = $this->eventFromRequest($request);

        return view('events.register', [
            'event' => $event,
            'questions' => $this->questions(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $event = $this->eventFromRequest($request);

        if (! ($event['registration_open'] ?? true)) {
            return redirect()
                ->route('events')
                ->with('status', 'Registration for ' . $event['title'] . ' is currently closed.');
        }

        $questionRules = collect($this->questions())
            ->mapWithKeys(function (array $question): array {
                $rules = ['nullable', 'string', 'max:2000'];

                if ($question['required'] ?? false) {
                    $rules[0] = 'required';
                }

                return ['responses.' . $question['key'] => $rules];
            })
            ->all();

        $validated = $request->validate([
            'event_slug' => ['required', 'string', 'max:180'],
            'full_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:40'],
            'organization' => ['nullable', 'string', 'max:180'],
            'responses' => ['nullable', 'array'],
            ...$questionRules,
        ]);

        $duplicate = EventRegistration::query()
            ->where('event_slug', $event['slug'])
            ->where('email', $validated['email'])
            ->exists();

        if ($duplicate) {
            return back()
                ->withErrors(['email' => 'This email is already registered for this event.'])
                ->withInput();
        }

        $registration = EventRegistration::query()->create([
            'event_slug' => $event['slug'],
            'event_title' => $event['title'],
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'organization' => $validated['organization'] ?? null,
            'responses' => $validated['responses'] ?? [],
        ]);

        $this->sendNotifications($registration);

        return redirect()
            ->route('event.register', ['event' => $event['slug']])
            ->with('success_registration', 'Registration received. We will follow up with event details.');
    }

    public function index(): View
    {
        return view('admin.event-registrations.index', [
            'registrations' => EventRegistration::query()
                ->latest()
                ->paginate(20),
        ]);
    }

    public function show(EventRegistration $eventRegistration): View
    {
        return view('admin.event-registrations.show', [
            'registration' => $eventRegistration,
        ]);
    }

    public function export(): StreamedResponse
    {
        $fileName = 'event-registrations-' . now()->format('Y-m-d') . '.csv';
        $responseColumns = $this->responseColumns();

        return response()->streamDownload(function () use ($responseColumns): void {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'Name',
                'Email',
                'Phone',
                'Organization',
                'Event',
                'Date',
                ...array_values($responseColumns),
            ]);

            EventRegistration::query()
                ->latest()
                ->chunk(100, function ($registrations) use ($handle, $responseColumns): void {
                    foreach ($registrations as $registration) {
                        fputcsv($handle, [
                            $registration->full_name,
                            $registration->email,
                            $this->excelText($registration->phone),
                            $registration->organization,
                            $registration->event_title,
                            $this->excelText($registration->created_at?->format('Y-m-d H:i:s')),
                            ...$this->responseValues($registration->responses ?? [], array_keys($responseColumns)),
                        ]);
                    }
                });

            fclose($handle);
        }, $fileName, ['Content-Type' => 'text/csv']);
    }

    private function eventFromRequest(Request $request): array
    {
        $slug = (string) $request->input('event', $request->input('event_slug', ''));
        $events = collect($this->siteData('events', []))
            ->map(fn (array $event): array => [
                ...$event,
                'slug' => $event['slug'] ?? Str::slug($event['title']),
            ]);

        $event = $events->firstWhere('slug', $slug) ?? $events->first();

        abort_unless($event, 404);

        return $event;
    }

    private function questions(): array
    {
        return $this->siteData('event_registration_questions', []);
    }

    private function responseColumns(): array
    {
        $columns = collect($this->questions())
            ->mapWithKeys(fn (array $question): array => [
                (string) $question['key'] => (string) $question['label'],
            ])
            ->all();

        EventRegistration::query()
            ->whereNotNull('responses')
            ->get(['responses'])
            ->each(function (EventRegistration $registration) use (&$columns): void {
                $responses = $registration->responses ?? [];

                foreach (array_keys($responses ?? []) as $key) {
                    $columns[$key] ??= Str::headline((string) $key);
                }
            });

        return $columns;
    }

    private function responseValues(array $responses, array $keys): array
    {
        return collect($keys)
            ->map(fn (string $key): string => $this->formatCsvValue($responses[$key] ?? ''))
            ->all();
    }

    private function formatCsvValue(mixed $value): string
    {
        if (is_array($value)) {
            return collect($value)->map(fn (mixed $item): string => $this->formatCsvValue($item))->implode('; ');
        }

        return trim((string) $value);
    }

    private function excelText(?string $value): string
    {
        $value = trim((string) $value);

        return $value === '' ? '' : '="' . str_replace('"', '""', $value) . '"';
    }

    private function siteData(string $key, mixed $default = null): mixed
    {
        try {
            $editableSite = SiteSetting::query()
                ->where('key', 'site')
                ->value('value');
        } catch (QueryException) {
            $editableSite = null;
        }

        return data_get($editableSite, $key, config('site.' . $key, $default));
    }

    private function sendNotifications(EventRegistration $registration): void
    {
        try {
            $adminEmail = config('mail.from.address');
            $organizationEmail = config('site.organization.contact.email');

            Mail::to($organizationEmail ?: $adminEmail)
                ->send(new EventRegistrationSubmitted($registration));

            Mail::to($registration->email)
                ->send(new EventRegistrationSubmitted($registration, false));
        } catch (\Throwable) {
            report('Event registration email could not be sent for registration ID ' . $registration->id);
        }
    }
}
