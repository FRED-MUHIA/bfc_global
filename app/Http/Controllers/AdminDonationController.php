<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminDonationController extends Controller
{
    public function edit(): View
    {
        return view('admin.donations.edit', [
            'donationSettings' => $this->editableSite()['donation_settings'] ?? config('site.donation_settings', []),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'donation_settings.heading' => ['required', 'string', 'max:180'],
            'donation_settings.description' => ['nullable', 'string', 'max:500'],
            'donation_settings.options_heading' => ['required', 'string', 'max:180'],
            'donation_settings.options_eyebrow' => ['required', 'string', 'max:120'],
            'donation_settings.preset_amounts' => ['required', 'array', 'min:1'],
            'donation_settings.preset_amounts.*' => ['required', 'numeric', 'min:1', 'max:999999'],
            'donation_settings.giving_options' => ['nullable', 'array'],
            'donation_settings.giving_options.*.title' => ['nullable', 'string', 'max:120'],
            'donation_settings.giving_options.*.description' => ['nullable', 'string', 'max:500'],
            'donation_settings.program_default_label' => ['required', 'string', 'max:180'],
            'donation_settings.show_programs' => ['nullable', 'boolean'],
            'donation_settings.show_events' => ['nullable', 'boolean'],
            'donation_settings.allow_monthly' => ['nullable', 'boolean'],
            'donation_settings.paypal_enabled' => ['nullable', 'boolean'],
            'donation_settings.paypal_mode' => ['required', 'string', 'in:sandbox,live'],
            'donation_settings.paypal_client_id' => ['nullable', 'string', 'max:500'],
            'donation_settings.paypal_secret' => ['nullable', 'string', 'max:500'],
            'donation_settings.paypal_currency' => ['required', 'string', 'size:3'],
            'donation_settings.paypal_help_text' => ['nullable', 'string', 'max:500'],
        ]);

        $site = $this->editableSite();
        $settings = $validated['donation_settings'];
        $settings['show_programs'] = $request->boolean('donation_settings.show_programs');
        $settings['show_events'] = $request->boolean('donation_settings.show_events');
        $settings['allow_monthly'] = $request->boolean('donation_settings.allow_monthly');
        $settings['paypal_enabled'] = $request->boolean('donation_settings.paypal_enabled');
        $settings['paypal_currency'] = strtoupper($settings['paypal_currency']);
        if (blank($settings['paypal_secret'] ?? null)) {
            $settings['paypal_secret'] = $site['donation_settings']['paypal_secret'] ?? config('site.donation_settings.paypal_secret', '');
        }
        $settings['preset_amounts'] = collect($settings['preset_amounts'])
            ->filter(fn ($amount): bool => (float) $amount > 0)
            ->map(fn ($amount): int|float => (float) $amount == (int) $amount ? (int) $amount : (float) $amount)
            ->values()
            ->all();
        $settings['giving_options'] = collect($settings['giving_options'] ?? [])
            ->filter(fn (array $option): bool => filled($option['title'] ?? null) || filled($option['description'] ?? null))
            ->values()
            ->all();

        $site['donation_settings'] = $settings;
        unset($site['admin']);

        SiteSetting::query()->updateOrCreate(
            ['key' => 'site'],
            ['value' => $site],
        );

        return redirect()
            ->route('admin.donations.edit')
            ->with('status', 'Donation settings saved.');
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
}
