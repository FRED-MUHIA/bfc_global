@extends('layouts.app', [
    'title' => 'Get Involved',
    'description' => 'Volunteer, partner, sponsor, and support programs that strengthen families and communities.',
])

@section('content')
    @include('partials.page-header', [
        'eyebrow' => 'Get Involved',
        'headerTitle' => 'Join hands with us to uplift families and communities',
        'headerDescription' => 'Your time, expertise, and partnership can help deliver hope, practical care, and sustainable support to households in need.',
        'primaryAction' => ['label' => 'Volunteer Form', 'to' => '#volunteer-form'],
        'secondaryAction' => ['label' => 'Partnership Form', 'to' => '#partnership-form'],
    ])

    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="mb-10 max-w-3xl">
                <h2 class="text-3xl leading-tight md:text-4xl">Ways You Can Serve</h2>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                @foreach (($site['involvement_opportunities'] ?? []) as $opportunity)
                    @php
                        $cardStyles = [
                            ['card' => 'bg-pine text-white border-pine', 'title' => 'text-white', 'text' => 'text-white/85'],
                            ['card' => 'bg-ember text-white border-ember', 'title' => 'text-white', 'text' => 'text-white/90'],
                            ['card' => 'bg-sage text-white border-sage', 'title' => 'text-white', 'text' => 'text-white/85'],
                            ['card' => 'bg-mist text-pine border-sage/20', 'title' => 'text-pine', 'text' => 'text-slate'],
                        ];
                        $style = $cardStyles[$loop->index % count($cardStyles)];
                    @endphp
                    <button
                        type="button"
                        class="w-full rounded-3xl border p-6 text-left shadow-soft transition hover:-translate-y-1 focus:outline-none focus:ring-4 focus:ring-sage/30 md:p-8 {{ $style['card'] }}"
                        data-involvement-open
                        data-role="{{ $opportunity['title'] }}"
                    >
                        <h3 class="text-2xl {{ $style['title'] }}">{{ $opportunity['title'] }}</h3>
                        <p class="mt-3 {{ $style['text'] }}">{{ $opportunity['description'] }}</p>
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <div class="fixed inset-0 z-[70] hidden items-center justify-center bg-pine/70 px-4 py-6 backdrop-blur-sm" data-involvement-modal>
        <div class="max-h-[92vh] w-full max-w-2xl overflow-y-auto rounded-2xl bg-white p-6 shadow-2xl md:p-8" role="dialog" aria-modal="true" aria-labelledby="involvement-modal-title">
            <div class="flex items-start justify-between gap-4">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.14em] text-ember">Get Involved</p>
                    <h2 id="involvement-modal-title" class="mt-2 text-3xl leading-tight text-pine">Apply to Serve</h2>
                    <p class="mt-2 text-sm text-slate/75">Fill this form and our team will receive your selected serving option by email.</p>
                </div>
                <button type="button" class="rounded-full border border-sand px-4 py-2 text-sm font-bold text-pine hover:bg-mist" data-involvement-close>Close</button>
            </div>

            <form class="mt-6 grid gap-4 md:grid-cols-2" method="POST" action="{{ route('forms.volunteer') }}">
                @csrf
                <label class="block md:col-span-2">
                    <span class="mb-2 block text-sm font-semibold text-pine">Selected Option</span>
                    <input class="field-input bg-mist/40" type="text" name="role" value="{{ old('role') }}" readonly data-involvement-role>
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-pine">Full Name *</span>
                    <input class="field-input" type="text" name="full_name" value="{{ old('full_name') }}" required>
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-pine">Email Address *</span>
                    <input class="field-input" type="email" name="email" value="{{ old('email') }}" required>
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-pine">Phone Number *</span>
                    <input class="field-input" type="text" name="phone" value="{{ old('phone') }}" required>
                </label>
                <label class="block">
                    <span class="mb-2 block text-sm font-semibold text-pine">Availability</span>
                    <input class="field-input" type="text" name="availability" value="{{ old('availability') }}" placeholder="Weeknights, weekends, mornings...">
                </label>
                <label class="block md:col-span-2">
                    <span class="mb-2 block text-sm font-semibold text-pine">Message / How would you like to serve? *</span>
                    <textarea class="field-input" name="interests" rows="4" required>{{ old('interests') }}</textarea>
                </label>
                <div class="flex flex-wrap justify-end gap-3 md:col-span-2">
                    <button type="button" class="rounded-full border border-sand px-5 py-3 text-sm font-bold text-slate hover:bg-mist" data-involvement-close>Cancel</button>
                    <button type="submit" class="rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">
                        Send Form
                    </button>
                </div>
            </form>
        </div>
    </div>

    <section id="volunteer-form" class="bg-white/70 py-16 md:py-20">
        <div class="container-base">
            <div class="mb-10 max-w-3xl">
                <h2 class="text-3xl leading-tight md:text-4xl">Volunteer with BFC Global</h2>
            </div>

            <section class="glass-panel p-6 md:p-8">
                <h3 class="text-2xl">Volunteer Sign-Up</h3>
                <p class="mt-2 text-sm text-slate/80">
                    Tell us about your availability, strengths, and how you would like to serve.
                </p>
                <form class="mt-6 grid gap-4 md:grid-cols-2" method="POST" action="{{ route('forms.volunteer') }}">
                    @csrf
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-pine">Full Name *</span>
                        <input class="field-input" type="text" name="full_name" value="{{ old('full_name') }}" required>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-pine">Email Address *</span>
                        <input class="field-input" type="email" name="email" value="{{ old('email') }}" required>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-pine">Phone Number *</span>
                        <input class="field-input" type="text" name="phone" value="{{ old('phone') }}" required>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-pine">Selected Option</span>
                        <input class="field-input" type="text" name="role" value="{{ old('role') }}" placeholder="Volunteer Mentor, Prayer & Care Team...">
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-pine">Availability</span>
                        <input class="field-input" type="text" name="availability" value="{{ old('availability') }}" placeholder="Weeknights, weekends, mornings...">
                    </label>
                    <label class="block md:col-span-2">
                        <span class="mb-2 block text-sm font-semibold text-pine">Volunteer Interests *</span>
                        <textarea class="field-input" name="interests" rows="4" required placeholder="Mentorship, events, tutoring, admin support, family care, etc.">{{ old('interests') }}</textarea>
                    </label>
                    <div class="md:col-span-2">
                        <button type="submit" class="inline-flex items-center justify-center rounded-full bg-pine px-5 py-3 text-sm font-semibold tracking-wide text-white transition hover:bg-sage">
                            Submit Volunteer Form
                        </button>
                    </div>
                </form>

                @if ($errors->any())
                    <p class="mt-4 text-sm font-semibold text-rose-700">{{ $errors->first() }}</p>
                @endif
                @if (session('success_volunteer'))
                    <p class="mt-4 text-sm font-semibold text-sage">{{ session('success_volunteer') }}</p>
                @endif
            </section>
        </div>
    </section>

    <section id="partnership-form" class="py-16 md:py-20">
        <div class="container-base">
            <div class="mb-10 max-w-3xl">
                <h2 class="text-3xl leading-tight md:text-4xl">Partnership Inquiry</h2>
            </div>

            <section class="glass-panel p-6 md:p-8">
                <h3 class="text-2xl">Partnership Inquiry</h3>
                <p class="mt-2 text-sm text-slate/80">
                    We collaborate with schools, churches, health providers, and organizations committed to family wellbeing.
                </p>
                <form class="mt-6 grid gap-4 md:grid-cols-2" method="POST" action="{{ route('forms.partnership') }}">
                    @csrf
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-pine">Organization Name *</span>
                        <input class="field-input" type="text" name="organization_name" value="{{ old('organization_name') }}" required>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-pine">Primary Contact Name *</span>
                        <input class="field-input" type="text" name="contact_name" value="{{ old('contact_name') }}" required>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-pine">Email Address *</span>
                        <input class="field-input" type="email" name="email" value="{{ old('email') }}" required>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-pine">Phone Number</span>
                        <input class="field-input" type="text" name="phone" value="{{ old('phone') }}">
                    </label>
                    <label class="block md:col-span-2">
                        <span class="mb-2 block text-sm font-semibold text-pine">Partnership Goals *</span>
                        <textarea class="field-input" name="partnership_goals" rows="5" required placeholder="Tell us how you would like to partner with BFC Global.">{{ old('partnership_goals') }}</textarea>
                    </label>
                    <div class="md:col-span-2">
                        <button type="submit" class="inline-flex items-center justify-center rounded-full bg-sage px-5 py-3 text-sm font-semibold tracking-wide text-white transition hover:bg-pine">
                            Submit Partnership Request
                        </button>
                    </div>
                </form>

                @if ($errors->any())
                    <p class="mt-4 text-sm font-semibold text-rose-700">{{ $errors->first() }}</p>
                @endif
                @if (session('success_partnership'))
                    <p class="mt-4 text-sm font-semibold text-sage">{{ session('success_partnership') }}</p>
                @endif
            </section>
        </div>
    </section>

    @include('partials.cta-banner', [
        'bannerTitle' => 'Every contribution helps a family move from survival to stability.',
        'bannerDescription' => 'Serve monthly, join outreach events, or partner your organization with our mission.',
        'primaryAction' => ['label' => 'Contact Team', 'to' => '/contact'],
        'secondaryAction' => ['label' => 'Ministry Programs', 'to' => '/ministry-programs'],
    ])

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const modal = document.querySelector('[data-involvement-modal]');
            const roleInput = document.querySelector('[data-involvement-role]');

            const openModal = (role) => {
                if (!modal || !roleInput) {
                    return;
                }

                roleInput.value = role;
                modal.classList.remove('hidden');
                modal.classList.add('flex');
                document.body.classList.add('overflow-hidden');
                modal.querySelector('input[name="full_name"]')?.focus();
            };

            const closeModal = () => {
                modal?.classList.add('hidden');
                modal?.classList.remove('flex');
                document.body.classList.remove('overflow-hidden');
            };

            document.querySelectorAll('[data-involvement-open]').forEach((button) => {
                button.addEventListener('click', () => openModal(button.dataset.role || 'Volunteer'));
            });

            document.querySelectorAll('[data-involvement-close]').forEach((button) => {
                button.addEventListener('click', closeModal);
            });

            modal?.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });

            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape') {
                    closeModal();
                }
            });
        });
    </script>
@endsection
