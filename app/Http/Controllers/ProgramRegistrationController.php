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
        return view('admin.program-registrations.index', [
            'registrations' => ProgramRegistration::query()->latest()->paginate(20),
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

        return response()->streamDownload(function (): void {
            $handle = fopen('php://output', 'w');
            fputcsv($handle, ['Name', 'Email', 'Phone', 'Organization', 'Program', 'Cohort', 'Date', 'Responses']);

            ProgramRegistration::query()
                ->latest()
                ->chunk(100, function ($registrations) use ($handle): void {
                    foreach ($registrations as $registration) {
                        fputcsv($handle, [
                            $registration->full_name,
                            $registration->email,
                            $registration->phone,
                            $registration->organization,
                            $registration->program_title,
                            $registration->cohort,
                            $registration->created_at?->format('Y-m-d H:i:s'),
                            json_encode($registration->responses ?? [], JSON_UNESCAPED_SLASHES),
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
