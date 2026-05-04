@extends('layouts.app', [
    'title' => 'Donate',
    'description' => 'Give to a BFC Global program, event, or general family support fund through PayPal.',
])

@section('content')
    @php($donationSettings = $site['donation_settings'] ?? [])
    @php($paypalMode = $paypalMode ?? ($donationSettings['paypal_mode'] ?? 'sandbox'))
    @php($currencySymbol = $paypalCurrency === 'USD' ? '$' : $paypalCurrency . ' ')
    <section id="donation-form" class="py-16 md:py-20">
        <div class="container-base">
            <div class="grid gap-8 lg:grid-cols-[0.92fr_1.08fr]">
                <aside class="glass-panel h-fit p-6 md:p-8">
                    <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">{{ $donationSettings['options_eyebrow'] ?? 'Giving Options' }}</p>
                    <h2 class="mt-3 text-3xl leading-tight">{{ $donationSettings['options_heading'] ?? 'Where your donation can go' }}</h2>
                    <div class="mt-6 grid gap-4">
                        @foreach (($donationSettings['giving_options'] ?? []) as $option)
                            <article class="rounded-2xl border border-sand bg-white/70 p-4">
                                <h3 class="text-xl">{{ $option['title'] }}</h3>
                                <p class="mt-2 text-sm text-slate/80">{{ $option['description'] }}</p>
                            </article>
                        @endforeach
                    </div>
                </aside>

                <section class="glass-panel p-6 md:p-8">
                    <h2 class="text-3xl leading-tight">{{ $donationSettings['heading'] ?? 'Make a Donation' }}</h2>
                    <p class="mt-2 text-sm text-slate/80">
                        {{ $donationSettings['description'] ?? 'Complete the form first, then use PayPal to securely finish your gift.' }}
                    </p>

                    <form
                        class="mt-6 grid gap-4 md:grid-cols-2"
                        method="POST"
                        action="{{ route('forms.donation') }}"
                        data-donation-form
                        data-paypal-currency="{{ $paypalCurrency }}"
                    >
                        @csrf
                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-pine">Donation Type *</span>
                            <select class="field-input" name="donation_type" data-donation-type required>
                                <option value="general" @selected(old('donation_type') === 'general')>General Donation</option>
                                @if ($donationSettings['show_programs'] ?? true)
                                    <option value="program" @selected(old('donation_type') === 'program')>Specific Program</option>
                                @endif
                                @if ($donationSettings['show_events'] ?? true)
                                    <option value="event" @selected(old('donation_type') === 'event')>Specific Event</option>
                                @endif
                            </select>
                        </label>

                        <label class="block" data-program-field>
                            <span class="mb-2 block text-sm font-semibold text-pine">Program</span>
                            <select class="field-input" name="designation">
                                <option value="">{{ $donationSettings['program_default_label'] ?? 'General Family Support' }}</option>
                                @foreach (($site['ministry_programs'] ?? []) as $program)
                                    @php($programTitle = $program['menu_label'] ?? $program['title'])
                                    <option value="{{ $programTitle }}" @selected(old('designation') === $programTitle)>{{ $programTitle }}</option>
                                @endforeach
                            </select>
                        </label>

                        <label class="block hidden" data-event-field>
                            <span class="mb-2 block text-sm font-semibold text-pine">Event Name</span>
                            <input class="field-input" type="text" name="event_name" value="{{ old('event_name') }}" placeholder="Family night, workshop, outreach event...">
                        </label>

                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-pine">Frequency *</span>
                            <select class="field-input" name="frequency" required>
                                <option value="one-time" @selected(old('frequency') !== 'monthly')>One-time</option>
                                @if ($donationSettings['allow_monthly'] ?? true)
                                    <option value="monthly" @selected(old('frequency') === 'monthly')>Monthly pledge</option>
                                @endif
                            </select>
                        </label>

                        <div class="md:col-span-2">
                            <span class="mb-2 block text-sm font-semibold text-pine">Amount *</span>
                            <div class="grid gap-3 sm:grid-cols-4">
                                @foreach (($donationSettings['preset_amounts'] ?? [25, 50, 100]) as $amount)
                                    <label class="cursor-pointer">
                                        <input class="peer sr-only" type="radio" name="preset_amount" value="{{ $amount }}" data-preset-amount>
                                        <span class="block rounded-2xl border border-sand bg-white px-4 py-3 text-center text-sm font-bold text-pine transition peer-checked:border-pine peer-checked:bg-mist">
                                            {{ $currencySymbol }}{{ $amount }}
                                        </span>
                                    </label>
                                @endforeach
                                <label class="block">
                                    <input class="field-input" type="number" name="amount" value="{{ old('amount') }}" min="1" step="0.01" placeholder="Custom" data-donation-amount required>
                                </label>
                            </div>
                        </div>

                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-pine">Full Name *</span>
                            <input class="field-input" type="text" name="donor_name" value="{{ old('donor_name') }}" required>
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-pine">Email Address *</span>
                            <input class="field-input" type="email" name="email" value="{{ old('email') }}" required>
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-pine">Phone Number</span>
                            <input class="field-input" type="text" name="phone" value="{{ old('phone') }}">
                        </label>
                        <label class="block">
                            <span class="mb-2 block text-sm font-semibold text-pine">Currency</span>
                            <input class="field-input" type="text" name="currency" value="{{ $paypalCurrency }}" readonly>
                        </label>
                        <label class="block md:col-span-2">
                            <span class="mb-2 block text-sm font-semibold text-pine">Message or Dedication</span>
                            <textarea class="field-input" name="message" rows="4" placeholder="Optional note for our team">{{ old('message') }}</textarea>
                        </label>

                        <input type="hidden" name="paypal_order_id" data-paypal-order-id>
                        <input type="hidden" name="paypal_payer_id" data-paypal-payer-id>
                        <input type="hidden" name="status" value="pending" data-donation-status>

                        <div class="md:col-span-2">
                            @if ($paypalClientId)
                                <div id="paypal-button-container" class="max-w-md" data-paypal-buttons data-paypal-mode="{{ $paypalMode }}"></div>
                                <p data-donation-message class="mt-4 text-sm font-semibold"></p>
                            @else
                                <div class="rounded-2xl border border-ember/30 bg-ember/10 p-4 text-sm text-slate/85">
                                    {{ $donationSettings['paypal_help_text'] ?? 'PayPal checkout is ready to enable. Add your PayPal Client ID in Donation Management to show the PayPal payment button.' }}
                                </div>
                                <button type="submit" class="mt-4 inline-flex items-center justify-center rounded-full bg-pine px-5 py-3 text-sm font-semibold tracking-wide text-white transition hover:bg-sage">
                                    Submit Donation Details
                                </button>
                            @endif
                        </div>
                    </form>

                    @if ($errors->any())
                        <p class="mt-4 text-sm font-semibold text-rose-700">{{ $errors->first() }}</p>
                    @endif
                    @if (session('success_donation'))
                        <p class="mt-4 text-sm font-semibold text-sage">{{ session('success_donation') }}</p>
                    @endif
                </section>
            </div>
        </div>
    </section>

    @if ($paypalClientId)
        <script src="https://www.paypal.com/sdk/js?client-id={{ urlencode($paypalClientId) }}&currency={{ urlencode($paypalCurrency) }}&intent=capture" data-sdk-integration-source="developer-studio"></script>
    @endif
@endsection
