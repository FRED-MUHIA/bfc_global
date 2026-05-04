<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class AdminBrandingController extends Controller
{
    public function edit(): View
    {
        return view('admin.branding.edit', [
            'branding' => $this->editableSite()['branding'] ?? config('site.branding', []),
            'organization' => $this->editableSite()['organization'] ?? config('site.organization', []),
            'whatsapp' => $this->editableSite()['whatsapp'] ?? config('site.whatsapp', []),
        ]);
    }

    public function update(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'organization.short_name' => ['required', 'string', 'max:120'],
            'organization.name' => ['required', 'string', 'max:180'],
            'branding.site_name' => ['required', 'string', 'max:120'],
            'branding.tagline' => ['nullable', 'string', 'max:160'],
            'branding.logo_url' => ['nullable', 'string', 'max:800'],
            'branding.favicon_url' => ['nullable', 'string', 'max:800'],
            'branding.join_label' => ['required', 'string', 'max:40'],
            'branding.join_url' => ['required', 'string', 'max:300'],
            'branding.donate_label' => ['required', 'string', 'max:40'],
            'branding.donate_url' => ['required', 'string', 'max:300'],
            'branding.logo_upload' => ['nullable', 'image', 'max:5120'],
            'branding.favicon_upload' => ['nullable', 'file', 'mimes:ico,png,jpg,jpeg,svg,webp', 'max:1024'],
            'whatsapp.enabled' => ['nullable', 'boolean'],
            'whatsapp.phone' => ['required', 'string', 'max:40'],
            'whatsapp.message' => ['nullable', 'string', 'max:500'],
            'whatsapp.label' => ['required', 'string', 'max:80'],
        ]);

        $site = $this->editableSite();
        $branding = [
            ...($site['branding'] ?? []),
            ...($validated['branding'] ?? []),
        ];

        if ($request->hasFile('branding.logo_upload')) {
            $branding['logo_url'] = PublicUpload::store($request->file('branding.logo_upload'), 'branding')['url'];
        }

        if ($request->hasFile('branding.favicon_upload')) {
            $branding['favicon_url'] = PublicUpload::store($request->file('branding.favicon_upload'), 'branding', false)['url'];
        }

        unset($branding['logo_upload'], $branding['favicon_upload']);

        $site['organization']['short_name'] = $validated['organization']['short_name'];
        $site['organization']['name'] = $validated['organization']['name'];
        $site['organization']['tagline'] = $branding['tagline'] ?? $site['organization']['tagline'] ?? '';
        $site['branding'] = $branding;
        $site['whatsapp'] = [
            ...($site['whatsapp'] ?? []),
            ...($validated['whatsapp'] ?? []),
            'enabled' => $request->boolean('whatsapp.enabled'),
        ];
        unset($site['admin']);

        SiteSetting::query()->updateOrCreate(
            ['key' => 'site'],
            ['value' => $site],
        );

        return redirect()
            ->route('admin.branding.edit')
            ->with('status', 'Branding saved.');
    }

    private function editableSite(): array
    {
        $site = config('site');
        $editableSite = SiteSetting::query()->where('key', 'site')->value('value');

        if (is_array($editableSite)) {
            $site = array_replace_recursive($site, $editableSite);
        }

        unset($site['admin']);

        return $site;
    }
}
