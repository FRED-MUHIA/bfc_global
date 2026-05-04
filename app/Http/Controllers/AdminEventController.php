<?php

namespace App\Http\Controllers;

use App\Models\EventRegistration;
use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminEventController extends Controller
{
    public function index(): View
    {
        $events = collect($this->editableSite()['events'] ?? [])
            ->map(fn (array $event): array => [
                ...$event,
                'slug' => $event['slug'] ?? Str::slug($event['title']),
                'registrations_count' => EventRegistration::query()
                    ->where('event_slug', $event['slug'] ?? Str::slug($event['title']))
                    ->count(),
            ]);

        return view('admin.events.index', compact('events'));
    }

    public function create(): View
    {
        return view('admin.events.form', [
            'event' => [
                'slug' => '',
                'title' => '',
                'date' => '',
                'time' => '',
                'location' => '',
                'category' => '',
                'description' => '',
                'image' => '',
            ],
            'mode' => 'create',
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $event = $this->validatedEvent($request);
        $site = $this->editableSite();
        $events = $site['events'] ?? [];

        if (collect($events)->contains(fn (array $existing): bool => ($existing['slug'] ?? '') === $event['slug'])) {
            return back()
                ->withErrors(['slug' => 'An event with this slug already exists.'])
                ->withInput();
        }

        $events[] = $event;
        $site['events'] = array_values($events);
        $this->saveSite($site);

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Event created.');
    }

    public function edit(string $event): View
    {
        $eventDetails = $this->findEvent($event);

        return view('admin.events.form', [
            'event' => $eventDetails,
            'mode' => 'edit',
        ]);
    }

    public function update(Request $request, string $event): RedirectResponse
    {
        $updatedEvent = $this->validatedEvent($request, $event);
        $site = $this->editableSite();
        $events = collect($site['events'] ?? [])
            ->map(function (array $existing) use ($event, $updatedEvent): array {
                $existingSlug = $existing['slug'] ?? Str::slug($existing['title']);

                return $existingSlug === $event ? $updatedEvent : $existing;
            })
            ->values()
            ->all();

        $site['events'] = $events;
        $this->saveSite($site);

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Event updated.');
    }

    public function destroy(string $event): RedirectResponse
    {
        $site = $this->editableSite();
        $site['events'] = collect($site['events'] ?? [])
            ->reject(fn (array $existing): bool => ($existing['slug'] ?? Str::slug($existing['title'])) === $event)
            ->values()
            ->all();
        $this->saveSite($site);

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Event deleted.');
    }

    public function toggleRegistration(string $event): RedirectResponse
    {
        $site = $this->editableSite();
        $site['events'] = collect($site['events'] ?? [])
            ->map(function (array $existing) use ($event): array {
                $existingSlug = $existing['slug'] ?? Str::slug($existing['title']);

                if ($existingSlug === $event) {
                    $existing['registration_open'] = ! (bool) ($existing['registration_open'] ?? true);
                }

                return $existing;
            })
            ->values()
            ->all();
        $this->saveSite($site);

        return redirect()
            ->route('admin.events.index')
            ->with('status', 'Registration status updated.');
    }

    private function validatedEvent(Request $request, ?string $currentSlug = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180'],
            'date' => ['required', 'string', 'max:120'],
            'time' => ['required', 'string', 'max:120'],
            'location' => ['required', 'string', 'max:180'],
            'category' => ['required', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:1000'],
            'image' => ['nullable', 'string', 'max:800'],
            'image_upload' => ['nullable', 'image', 'max:5120'],
            'registration_open' => ['nullable', 'boolean'],
        ]);

        $slug = Str::slug($validated['slug'] ?: $validated['title']);
        $image = $validated['image'] ?? '';

        if ($request->hasFile('image_upload')) {
            $image = Storage::url($request->file('image_upload')->store('events', 'public'));
        }

        if ($currentSlug && $slug !== $currentSlug) {
            EventRegistration::query()
                ->where('event_slug', $currentSlug)
                ->update(['event_slug' => $slug, 'event_title' => $validated['title']]);
        }

        return [
            'slug' => $slug,
            'title' => trim($validated['title']),
            'date' => trim($validated['date']),
            'time' => trim($validated['time']),
            'location' => trim($validated['location']),
            'category' => trim($validated['category']),
            'description' => trim($validated['description']),
            'image' => $image,
            'registration_open' => $request->boolean('registration_open'),
        ];
    }

    private function findEvent(string $slug): array
    {
        $event = collect($this->editableSite()['events'] ?? [])
            ->first(fn (array $event): bool => ($event['slug'] ?? Str::slug($event['title'])) === $slug);

        abort_unless($event, 404);

        return [
            ...$event,
            'slug' => $event['slug'] ?? Str::slug($event['title']),
        ];
    }

    private function editableSite(): array
    {
        $site = config('site');
        $editableSite = SiteSetting::query()
            ->where('key', 'site')
            ->value('value');

        if (is_array($editableSite)) {
            $site = array_replace_recursive($site, $editableSite);
        }

        unset($site['admin']);

        return $site;
    }

    private function saveSite(array $site): void
    {
        unset($site['admin']);

        SiteSetting::query()->updateOrCreate(
            ['key' => 'site'],
            ['value' => $site],
        );
    }
}
