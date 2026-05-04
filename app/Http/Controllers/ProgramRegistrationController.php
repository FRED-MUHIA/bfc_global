<?php

namespace App\Http\Controllers;

use App\Mail\ProgramRegistrationSubmitted;
use App\Models\ProgramRegistration;
use App\Models\SiteSetting;
use Illuminate\Database\QueryException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Symfony\Component\HttpFoundation\StreamedResponse;

class ProgramRegistrationController extends Controller
{
    public function create(string $program): View
    {
        $programDetails = $this->program($program);

        return view('programs.register', [
            'program' => $programDetails,
            'questions' => $this->questions($programDetails),
            'cohorts' => $this->cohorts($programDetails),
        ]);
    }

    public function store(Request $request, string $program): RedirectResponse
    {
        $programDetails = $this->program($program);
        $questions = $this->questions($programDetails);
        $cohorts = $this->cohorts($programDetails);

        if (! data_get($programDetails, 'registration.open', true)) {
            return redirect()
                ->route('ministry-programs.show', $programDetails['slug'])
                ->with('status', 'Registration for ' . $programDetails['title'] . ' is currently closed.');
        }

        $questionRules = collect($questions)
            ->mapWithKeys(function (array $question): array {
                $rules = ['nullable', 'string', 'max:2000'];

                if ($question['required'] ?? false) {
                    $rules[0] = 'required';
                }

                return ['responses.' . $question['key'] => $rules];
            })
            ->all();

        $validated = $request->validate([
            'cohort' => [$cohorts ? 'required' : 'nullable', 'string', 'max:180'],
            'full_name' => ['required', 'string', 'max:150'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:40'],
            'organization' => ['nullable', 'string', 'max:180'],
            'responses' => ['nullable', 'array'],
            ...$questionRules,
        ]);

        $duplicate = ProgramRegistration::query()
            ->where('program_slug', $programDetails['slug'])
            ->where('cohort', $validated['cohort'] ?? null)
            ->where('email', $validated['email'])
            ->exists();

        if ($duplicate) {
            return back()
                ->withErrors(['email' => 'This email is already registered for this program intake.'])
                ->withInput();
        }

        $registration = ProgramRegistration::query()->create([
            'program_slug' => $programDetails['slug'],
            'program_title' => $programDetails['title'],
            'cohort' => $validated['cohort'] ?? null,
            'full_name' => $validated['full_name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'organization' => $validated['organization'] ?? null,
            'responses' => $validated['responses'] ?? [],
        ]);

        $this->sendNotifications($registration);

        return redirect()
            ->route('program.register', $programDetails['slug'])
            ->with('success_registration', 'Registration received. We will follow up with program details.');
    }

    public function index(): View
    {
        $registrations = ProgramRegistration::query()
            ->latest()
            ->paginate(50);

        return view('admin.program-registrations.index', [
            'registrations' => $registrations,
            'registrationsByProgram' => $registrations->getCollection()
                ->groupBy(fn (ProgramRegistration $registration): string => $registration->program_title ?: 'Untitled Program'),
        ]);
    }

    public function show(ProgramRegistration $programRegistration): View
    {
        return view('admin.program-registrations.show', [
            'registration' => $programRegistration,
        ]);
    }

    public function export(): StreamedResponse
    {
        $fileName = 'program-registrations-' . now()->format('Y-m-d') . '.csv';
        $responseColumns = $this->responseColumns();

        return response()->streamDownload(function () use ($responseColumns): void {
            $handle = fopen('php://output', 'w');
            fwrite($handle, "\xEF\xBB\xBF");
            fputcsv($handle, [
                'Name',
                'Email',
                'Phone',
                'Organization',
                'Program',
                'Cohort',
                'Date',
                ...array_values($responseColumns),
            ]);

            ProgramRegistration::query()
                ->latest()
                ->chunk(100, function ($registrations) use ($handle, $responseColumns): void {
                    foreach ($registrations as $registration) {
                        fputcsv($handle, [
                            $registration->full_name,
                            $registration->email,
                            $this->excelText($registration->phone),
                            $registration->organization,
                            $registration->program_title,
                            $registration->cohort,
                            $this->excelText($registration->created_at?->format('Y-m-d H:i:s')),
                            ...$this->responseValues($registration->responses ?? [], array_keys($responseColumns)),
                        ]);
                    }
                });

            fclose($handle);
        }, $fileName, ['Content-Type' => 'text/csv']);
    }

    private function program(string $slug): array
    {
        $program = collect($this->siteData('ministry_programs', []))
            ->map(fn (array $program): array => [
                ...$program,
                'slug' => $program['slug'] ?? Str::slug($program['title']),
            ])
            ->firstWhere('slug', $slug);

        abort_unless($program, 404);

        return $this->withDefaultRegistration($program);
    }

    private function withDefaultRegistration(array $program): array
    {
        $program['registration'] = [
            'open' => true,
            'button_label' => 'Register',
            'intro' => 'Choose an intake and tell us a little about yourself. Our team will follow up with the next steps.',
            'cohorts' => [
                'Current Intake',
                'Next Intake',
            ],
            'questions' => [
                [
                    'key' => 'interest',
                    'label' => 'What draws you to this program?',
                    'required' => true,
                ],
                [
                    'key' => 'expectations',
                    'label' => 'What would you like to receive from this program?',
                    'required' => false,
                ],
            ],
            ...($program['registration'] ?? []),
        ];

        return $program;
    }

    private function questions(array $program): array
    {
        return collect(data_get($program, 'registration.questions', []))
            ->filter(fn ($question): bool => filled($question['key'] ?? null) && filled($question['label'] ?? null))
            ->values()
            ->all();
    }

    private function cohorts(array $program): array
    {
        return collect(data_get($program, 'registration.cohorts', []))
            ->filter()
            ->values()
            ->all();
    }

    private function responseColumns(): array
    {
        $columns = collect($this->siteData('ministry_programs', []))
            ->flatMap(fn (array $program): array => data_get($this->withDefaultRegistration($program), 'registration.questions', []))
            ->filter(fn (array $question): bool => filled($question['key'] ?? null) && filled($question['label'] ?? null))
            ->mapWithKeys(fn (array $question): array => [
                (string) $question['key'] => (string) $question['label'],
            ])
            ->all();

        ProgramRegistration::query()
            ->whereNotNull('responses')
            ->get(['responses'])
            ->each(function (ProgramRegistration $registration) use (&$columns): void {
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

    private function sendNotifications(ProgramRegistration $registration): void
    {
        try {
            $adminEmail = config('mail.from.address');
            $organizationEmail = config('site.organization.contact.email');

            Mail::to($organizationEmail ?: $adminEmail)
                ->send(new ProgramRegistrationSubmitted($registration));

            Mail::to($registration->email)
                ->send(new ProgramRegistrationSubmitted($registration, false));
        } catch (\Throwable $exception) {
            report($exception);
        }
    }
}
