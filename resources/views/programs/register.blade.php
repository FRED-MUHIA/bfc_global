@extends('layouts.app', [
    'title' => 'Register for ' . $program['title'],
    'description' => 'Register your interest for ' . $program['title'],
])

@section('content')
    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="mx-auto max-w-3xl">
                <div class="mb-8">
                    <a href="{{ route('ministry-programs.show', $program['slug']) }}" class="text-sm font-bold text-pine hover:text-ember">Back to program</a>
                    <p class="mt-5 text-sm font-bold uppercase tracking-[0.15em] text-ember">Program Registration</p>
                    <h1 class="mt-3 text-4xl leading-tight md:text-5xl">{{ $program['title'] }}</h1>
                    <p class="mt-4 text-slate/75">{{ data_get($program, 'registration.intro') }}</p>
                </div>

                @if (session('success_registration'))
                    <div class="mb-6 rounded-2xl border border-sage/30 bg-mist p-4 text-sm font-semibold text-pine">
                        {{ session('success_registration') }}
                    </div>
                @endif

                @if ($errors->any())
                    <div class="mb-6 rounded-2xl border border-red-200 bg-red-50 p-4 text-sm text-red-800">
                        {{ $errors->first() }}
                    </div>
                @endif

                @unless (session('success_registration'))
                <form method="POST" action="{{ route('program.register.store', $program['slug']) }}" class="glass-panel overflow-hidden p-6 md:p-8" data-multi-step-form>
                    @csrf

                    <div class="mb-8">
                        <div class="h-2 overflow-hidden rounded-full bg-sand">
                            <div class="h-full w-0 rounded-full bg-pine transition-all" data-progress-bar></div>
                        </div>
                        <p class="mt-3 text-sm font-semibold text-slate/70" data-step-label></p>
                    </div>

                    <div class="grid overflow-hidden">
                        <section data-step class="grid gap-4">
                            <h2 class="text-2xl">Choose Intake</h2>
                            @if ($cohorts)
                                <label class="grid gap-2">
                                    <span class="text-sm font-bold text-pine">Cohort / Intake *</span>
                                    <select name="cohort" class="field-input" required>
                                        <option value="">Select an intake</option>
                                        @foreach ($cohorts as $cohort)
                                            <option value="{{ $cohort }}" @selected(old('cohort') === $cohort)>{{ $cohort }}</option>
                                        @endforeach
                                    </select>
                                </label>
                            @else
                                <input type="hidden" name="cohort" value="">
                                <p class="rounded-2xl border border-sand bg-white p-4 text-slate/75">This program is currently receiving general registrations.</p>
                            @endif
                        </section>

                        <section data-step class="hidden grid gap-4">
                            <h2 class="text-2xl">Your Details</h2>
                            <label class="grid gap-2">
                                <span class="text-sm font-bold text-pine">Full Name *</span>
                                <input name="full_name" value="{{ old('full_name') }}" class="field-input" required>
                            </label>
                            <label class="grid gap-2">
                                <span class="text-sm font-bold text-pine">Email *</span>
                                <input type="email" name="email" value="{{ old('email') }}" class="field-input" required>
                            </label>
                        </section>

                        <section data-step class="hidden grid gap-4">
                            <h2 class="text-2xl">Contact</h2>
                            <label class="grid gap-2">
                                <span class="text-sm font-bold text-pine">Phone Number *</span>
                                <input name="phone" value="{{ old('phone') }}" class="field-input" required>
                            </label>
                            <label class="grid gap-2">
                                <span class="text-sm font-bold text-pine">School, Church, CU, or Organization</span>
                                <input name="organization" value="{{ old('organization') }}" class="field-input">
                            </label>
                        </section>

                        @foreach ($questions as $question)
                            <section data-step class="hidden grid gap-4">
                                <h2 class="text-2xl">{{ $question['label'] }}</h2>
                                <label class="grid gap-2">
                                    <span class="text-sm font-bold text-pine">
                                        Response @if ($question['required'] ?? false)*@endif
                                    </span>
                                    <textarea
                                        name="responses[{{ $question['key'] }}]"
                                        rows="5"
                                        class="field-input"
                                        @required($question['required'] ?? false)
                                    >{{ old('responses.' . $question['key']) }}</textarea>
                                </label>
                            </section>
                        @endforeach

                        <section data-step class="hidden grid gap-4">
                            <h2 class="text-2xl">Review</h2>
                            <div class="rounded-2xl border border-sand bg-white p-4">
                                <p class="text-sm font-bold uppercase tracking-[0.12em] text-ember">Program</p>
                                <p class="mt-2 font-semibold text-pine">{{ $program['title'] }}</p>
                            </div>
                            <div class="grid gap-3 rounded-2xl border border-sand bg-white p-4 text-sm" data-review-box></div>
                        </section>
                    </div>

                    <div class="mt-8 flex items-center justify-between gap-3">
                        <button type="button" data-prev-step class="rounded-full border border-sand bg-white px-5 py-3 text-sm font-bold text-pine transition hover:bg-mist">Previous</button>
                        <button type="button" data-next-step class="rounded-full bg-pine px-5 py-3 text-sm font-bold text-white transition hover:bg-sage">Next</button>
                        <button type="submit" data-submit-step class="hidden rounded-full bg-ember px-5 py-3 text-sm font-bold text-white transition hover:bg-ember/90">
                            <span data-submit-label>Submit Registration</span>
                            <span data-submit-loading class="hidden">Submitting...</span>
                        </button>
                    </div>
                </form>
                @endunless
            </div>
        </div>
    </section>

    @unless (session('success_registration'))
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('[data-multi-step-form]');
            if (!form) return;

            const steps = Array.from(form.querySelectorAll('[data-step]'));
            const previous = form.querySelector('[data-prev-step]');
            const next = form.querySelector('[data-next-step]');
            const submit = form.querySelector('[data-submit-step]');
            const progress = form.querySelector('[data-progress-bar]');
            const label = form.querySelector('[data-step-label]');
            const review = form.querySelector('[data-review-box]');
            const submitLabel = form.querySelector('[data-submit-label]');
            const submitLoading = form.querySelector('[data-submit-loading]');
            const storageKey = `program-registration-{{ $program['slug'] }}`;
            let current = Number(localStorage.getItem(`${storageKey}-step`) || 0);

            const fieldsForStorage = Array.from(form.querySelectorAll('input, textarea, select')).filter((input) => input.name && input.type !== 'hidden');
            fieldsForStorage.forEach((input) => {
                const stored = localStorage.getItem(`${storageKey}-${input.name}`);
                if (stored && !input.value) input.value = stored;
                input.addEventListener('input', () => localStorage.setItem(`${storageKey}-${input.name}`, input.value));
                input.addEventListener('change', () => localStorage.setItem(`${storageKey}-${input.name}`, input.value));
            });

            const render = () => {
                steps.forEach((step, index) => step.classList.toggle('hidden', index !== current));
                previous.classList.toggle('invisible', current === 0);
                next.classList.toggle('hidden', current === steps.length - 1);
                submit.classList.toggle('hidden', current !== steps.length - 1);
                progress.style.width = `${((current + 1) / steps.length) * 100}%`;
                label.textContent = `Step ${current + 1} of ${steps.length}`;

                if (current === steps.length - 1) {
                    review.innerHTML = fieldsForStorage.map((input) => `
                        <div>
                            <span class="font-bold text-pine">${input.closest('label')?.querySelector('span')?.textContent || input.name}</span>
                            <p class="mt-1 text-slate/80">${input.value || 'Not provided'}</p>
                        </div>
                    `).join('');
                }
            };

            const validateCurrent = () => {
                const fields = Array.from(steps[current].querySelectorAll('input, textarea, select'));
                return fields.every((field) => field.reportValidity());
            };

            previous.addEventListener('click', () => {
                current = Math.max(0, current - 1);
                localStorage.setItem(`${storageKey}-step`, current);
                render();
            });

            next.addEventListener('click', () => {
                if (!validateCurrent()) return;
                current = Math.min(steps.length - 1, current + 1);
                localStorage.setItem(`${storageKey}-step`, current);
                render();
            });

            form.addEventListener('submit', () => {
                submit.disabled = true;
                submitLabel.classList.add('hidden');
                submitLoading.classList.remove('hidden');
                localStorage.removeItem(`${storageKey}-step`);
            });

            render();
        });
    </script>
    @endunless
@endsection
