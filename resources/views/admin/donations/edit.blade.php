@extends('layouts.admin', ['title' => 'Donation Management'])

@section('content')
    <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-pine hover:text-sage">Back to dashboard</a>
    <h1 class="mt-2 text-4xl">Donation Management</h1>
    <p class="mt-2 text-slate/75">Edit donation page features independently from the page builder.</p>

    @if ($errors->any())
        <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.donations.update') }}" class="mt-7 grid gap-6">
        @csrf
        @method('PUT')

        <section class="rounded-lg border border-sand bg-white p-5">
            <h2 class="text-2xl">Donation Form Copy</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Form Heading</span>
                    <input name="donation_settings[heading]" value="{{ old('donation_settings.heading', $donationSettings['heading'] ?? '') }}" class="field-input" required>
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Program Default Label</span>
                    <input name="donation_settings[program_default_label]" value="{{ old('donation_settings.program_default_label', $donationSettings['program_default_label'] ?? '') }}" class="field-input" required>
                </label>
                <label class="grid gap-2 md:col-span-2">
                    <span class="text-sm font-bold text-pine">Form Description</span>
                    <textarea name="donation_settings[description]" rows="3" class="field-input">{{ old('donation_settings.description', $donationSettings['description'] ?? '') }}</textarea>
                </label>
                <label class="grid gap-2 md:col-span-2">
                    <span class="text-sm font-bold text-pine">PayPal Help Text</span>
                    <textarea name="donation_settings[paypal_help_text]" rows="3" class="field-input">{{ old('donation_settings.paypal_help_text', $donationSettings['paypal_help_text'] ?? '') }}</textarea>
                </label>
            </div>
        </section>

        <section class="rounded-lg border border-sand bg-white p-5">
            <h2 class="text-2xl">PayPal Integration</h2>
            <p class="mt-1 text-sm text-slate/70">Add your PayPal app keys here. Use sandbox while testing, then switch to live with your live client ID.</p>
            <div class="mt-5 flex flex-wrap gap-3">
                <label class="inline-flex items-center gap-2 rounded-full bg-mist px-4 py-2 text-sm font-bold text-pine">
                    <input type="checkbox" name="donation_settings[paypal_enabled]" value="1" @checked(old('donation_settings.paypal_enabled', $donationSettings['paypal_enabled'] ?? false))>
                    Enable PayPal button
                </label>
            </div>
            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">PayPal Mode</span>
                    <select name="donation_settings[paypal_mode]" class="field-input" required>
                        <option value="sandbox" @selected(old('donation_settings.paypal_mode', $donationSettings['paypal_mode'] ?? 'sandbox') === 'sandbox')>Sandbox</option>
                        <option value="live" @selected(old('donation_settings.paypal_mode', $donationSettings['paypal_mode'] ?? 'sandbox') === 'live')>Live</option>
                    </select>
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Currency</span>
                    <input name="donation_settings[paypal_currency]" value="{{ old('donation_settings.paypal_currency', $donationSettings['paypal_currency'] ?? 'USD') }}" maxlength="3" class="field-input uppercase" required>
                </label>
                <label class="grid gap-2 md:col-span-2">
                    <span class="text-sm font-bold text-pine">Client ID</span>
                    <input name="donation_settings[paypal_client_id]" value="{{ old('donation_settings.paypal_client_id', $donationSettings['paypal_client_id'] ?? '') }}" class="field-input" placeholder="PayPal REST app client ID">
                </label>
                <label class="grid gap-2 md:col-span-2">
                    <span class="text-sm font-bold text-pine">Secret Key</span>
                    <input type="password" name="donation_settings[paypal_secret]" value="" class="field-input" placeholder="{{ !empty($donationSettings['paypal_secret'] ?? '') ? 'Saved. Leave blank to keep current secret.' : 'PayPal REST app secret' }}">
                </label>
            </div>
        </section>

        <section class="rounded-lg border border-sand bg-white p-5">
            <h2 class="text-2xl">Features</h2>
            <div class="mt-5 flex flex-wrap gap-3">
                <label class="inline-flex items-center gap-2 rounded-full bg-mist px-4 py-2 text-sm font-bold text-pine">
                    <input type="checkbox" name="donation_settings[show_programs]" value="1" @checked(old('donation_settings.show_programs', $donationSettings['show_programs'] ?? true))>
                    Show program donations
                </label>
                <label class="inline-flex items-center gap-2 rounded-full bg-mist px-4 py-2 text-sm font-bold text-pine">
                    <input type="checkbox" name="donation_settings[show_events]" value="1" @checked(old('donation_settings.show_events', $donationSettings['show_events'] ?? true))>
                    Show event donations
                </label>
                <label class="inline-flex items-center gap-2 rounded-full bg-mist px-4 py-2 text-sm font-bold text-pine">
                    <input type="checkbox" name="donation_settings[allow_monthly]" value="1" @checked(old('donation_settings.allow_monthly', $donationSettings['allow_monthly'] ?? true))>
                    Allow monthly pledge
                </label>
            </div>
        </section>

        <section class="rounded-lg border border-sand bg-white p-5">
            <h2 class="text-2xl">Preset Amounts</h2>
            <div class="mt-5 grid gap-3 sm:grid-cols-3">
                @foreach (old('donation_settings.preset_amounts', $donationSettings['preset_amounts'] ?? [25, 50, 100]) as $index => $amount)
                    <label class="grid gap-2">
                        <span class="text-sm font-bold text-pine">Amount {{ $index + 1 }}</span>
                        <input type="number" min="1" step="0.01" name="donation_settings[preset_amounts][]" value="{{ $amount }}" class="field-input" required>
                    </label>
                @endforeach
            </div>
        </section>

        <section class="rounded-lg border border-sand bg-white p-5">
            <h2 class="text-2xl">Giving Options</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Options Eyebrow</span>
                    <input name="donation_settings[options_eyebrow]" value="{{ old('donation_settings.options_eyebrow', $donationSettings['options_eyebrow'] ?? '') }}" class="field-input" required>
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Options Heading</span>
                    <input name="donation_settings[options_heading]" value="{{ old('donation_settings.options_heading', $donationSettings['options_heading'] ?? '') }}" class="field-input" required>
                </label>
            </div>
            <div class="mt-5 grid gap-4">
                @foreach (old('donation_settings.giving_options', $donationSettings['giving_options'] ?? []) as $index => $option)
                    <div class="rounded-lg border border-sand bg-cream/40 p-4">
                        <p class="text-sm font-bold text-pine">Option {{ $index + 1 }}</p>
                        <div class="mt-3 grid gap-4 md:grid-cols-2">
                            <label class="grid gap-2">
                                <span class="text-sm font-bold text-pine">Title</span>
                                <input name="donation_settings[giving_options][{{ $index }}][title]" value="{{ $option['title'] ?? '' }}" class="field-input">
                            </label>
                            <label class="grid gap-2">
                                <span class="text-sm font-bold text-pine">Description</span>
                                <textarea name="donation_settings[giving_options][{{ $index }}][description]" rows="3" class="field-input">{{ $option['description'] ?? '' }}</textarea>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>

        <div class="sticky bottom-0 z-20 -mx-4 border-t border-sand bg-cream/95 px-4 py-4 backdrop-blur sm:mx-0 sm:rounded-lg sm:border">
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="rounded-full border border-sand bg-white px-5 py-3 text-sm font-bold text-slate hover:bg-mist">Cancel</a>
                <button type="submit" class="rounded-full bg-pine px-6 py-3 text-sm font-bold text-white hover:bg-sage">Save Donation Settings</button>
            </div>
        </div>
    </form>
@endsection
