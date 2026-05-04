@extends('layouts.app', [
    'title' => 'Contact',
    'description' => 'Reach out to Building Families and Community Global Trust for support, program questions, partnerships, and volunteer opportunities.',
])

@section('content')
    @include('partials.page-header', [
        'eyebrow' => 'Contact',
        'headerTitle' => 'We would love to hear from you',
        'headerDescription' => 'Connect with our team for support requests, event information, volunteer onboarding, and partnership opportunities.',
        'primaryAction' => ['label' => 'Get Involved', 'to' => '/get-involved'],
        'secondaryAction' => ['label' => 'Ministry Programs', 'to' => '/ministry-programs'],
    ])

    <section class="bg-white/70 py-16 md:py-20">
        <div class="container-base">
            <div class="mb-10 max-w-3xl">
                <h2 class="text-3xl leading-tight md:text-4xl">Send a Message</h2>
            </div>
            <section class="glass-panel p-6 md:p-8">
                <h3 class="text-2xl">Contact Us</h3>
                <p class="mt-2 text-sm text-slate/80">
                    Share your question and a team member will respond within two business days.
                </p>
                <form class="mt-6 grid gap-4 md:grid-cols-2" method="POST" action="{{ route('forms.contact') }}">
                    @csrf
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-pine">First Name *</span>
                        <input class="field-input" type="text" name="first_name" value="{{ old('first_name') }}" required>
                    </label>
                    <label class="block">
                        <span class="mb-2 block text-sm font-semibold text-pine">Last Name *</span>
                        <input class="field-input" type="text" name="last_name" value="{{ old('last_name') }}" required>
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
                        <span class="mb-2 block text-sm font-semibold text-pine">Message *</span>
                        <textarea class="field-input" name="message" rows="5" required>{{ old('message') }}</textarea>
                    </label>
                    <div class="md:col-span-2">
                        <button type="submit" class="inline-flex items-center justify-center rounded-full bg-pine px-5 py-3 text-sm font-semibold tracking-wide text-white transition hover:bg-sage">
                            Send Message
                        </button>
                    </div>
                </form>
                @if ($errors->any())
                    <p class="mt-4 text-sm font-semibold text-rose-700">{{ $errors->first() }}</p>
                @endif
                @if (session('success_contact'))
                    <p class="mt-4 text-sm font-semibold text-sage">{{ session('success_contact') }}</p>
                @endif
            </section>
        </div>
    </section>

    @include('partials.cta-banner', [
        'bannerTitle' => 'Need immediate guidance for a family situation?',
        'bannerDescription' => 'Use our support inquiry process so we can connect you with timely, compassionate care.',
        'primaryAction' => ['label' => 'Contact Our Team', 'to' => '/contact'],
        'secondaryAction' => ['label' => 'Get Involved', 'to' => '/get-involved'],
    ])
@endsection
