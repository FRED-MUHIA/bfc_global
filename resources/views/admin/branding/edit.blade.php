@extends('layouts.admin', ['title' => 'Header and Branding'])

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-pine hover:text-ember">Back to dashboard</a>
        <h1 class="mt-3 text-4xl">Header and Branding</h1>
        <p class="mt-2 max-w-3xl text-slate/75">Edit the public header, logo, favicon, and header action buttons. Uploaded images are attached to the site automatically.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            <p class="font-bold">Please fix these fields:</p>
            <ul class="mt-2 list-disc pl-5">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('admin.branding.update') }}" enctype="multipart/form-data" class="rounded-lg border border-sand bg-white p-6">
        @csrf
        @method('PUT')

        <div class="grid gap-5 md:grid-cols-2">
            <label class="block">
                <span class="text-sm font-bold text-pine">Header Site Name</span>
                <input name="branding[site_name]" value="{{ old('branding.site_name', $branding['site_name'] ?? $organization['short_name'] ?? '') }}" class="field-input mt-2">
            </label>

            <label class="block">
                <span class="text-sm font-bold text-pine">Header Tagline</span>
                <input name="branding[tagline]" value="{{ old('branding.tagline', $branding['tagline'] ?? '') }}" class="field-input mt-2">
            </label>

            <label class="block">
                <span class="text-sm font-bold text-pine">Organization Full Name</span>
                <input name="organization[name]" value="{{ old('organization.name', $organization['name'] ?? '') }}" class="field-input mt-2">
            </label>

            <label class="block">
                <span class="text-sm font-bold text-pine">Organization Short Name</span>
                <input name="organization[short_name]" value="{{ old('organization.short_name', $organization['short_name'] ?? '') }}" class="field-input mt-2">
            </label>
        </div>

        <div class="mt-8 grid gap-5 md:grid-cols-2">
            <div class="rounded-lg border border-sand p-4">
                <div class="flex items-center justify-between gap-4">
                    <h2 class="text-2xl">Logo</h2>
                    @if (!empty($branding['logo_url']))
                        <img src="{{ $branding['logo_url'] }}" alt="Current logo" class="h-14 w-14 object-contain">
                    @endif
                </div>
                <label class="mt-4 block">
                    <span class="text-sm font-bold text-pine">Logo URL</span>
                    <input name="branding[logo_url]" value="{{ old('branding.logo_url', $branding['logo_url'] ?? '') }}" class="field-input mt-2">
                </label>
                <label class="mt-4 block">
                    <span class="text-sm font-bold text-pine">Upload Logo</span>
                    <input type="file" name="branding[logo_upload]" accept="image/*" class="mt-2 block w-full rounded-lg border border-sand bg-white px-4 py-3 text-sm">
                </label>
            </div>

            <div class="rounded-lg border border-sand p-4">
                <div class="flex items-center justify-between gap-4">
                    <h2 class="text-2xl">Favicon</h2>
                    @if (!empty($branding['favicon_url']))
                        <img src="{{ $branding['favicon_url'] }}" alt="Current favicon" class="h-10 w-10 object-contain">
                    @endif
                </div>
                <label class="mt-4 block">
                    <span class="text-sm font-bold text-pine">Favicon URL</span>
                    <input name="branding[favicon_url]" value="{{ old('branding.favicon_url', $branding['favicon_url'] ?? '') }}" class="field-input mt-2">
                </label>
                <label class="mt-4 block">
                    <span class="text-sm font-bold text-pine">Upload Favicon</span>
                    <input type="file" name="branding[favicon_upload]" accept=".ico,image/*" class="mt-2 block w-full rounded-lg border border-sand bg-white px-4 py-3 text-sm">
                </label>
            </div>
        </div>

        <div class="mt-8 rounded-lg border border-sand p-4">
            <h2 class="text-2xl">Header Buttons</h2>
            <div class="mt-4 grid gap-5 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-bold text-pine">First Button Label</span>
                    <input name="branding[join_label]" value="{{ old('branding.join_label', $branding['join_label'] ?? 'Join Us') }}" class="field-input mt-2">
                </label>
                <label class="block">
                    <span class="text-sm font-bold text-pine">First Button Link</span>
                    <input name="branding[join_url]" value="{{ old('branding.join_url', $branding['join_url'] ?? '/get-involved') }}" class="field-input mt-2">
                </label>
                <label class="block">
                    <span class="text-sm font-bold text-pine">Second Button Label</span>
                    <input name="branding[donate_label]" value="{{ old('branding.donate_label', $branding['donate_label'] ?? 'Donate') }}" class="field-input mt-2">
                </label>
                <label class="block">
                    <span class="text-sm font-bold text-pine">Second Button Link</span>
                    <input name="branding[donate_url]" value="{{ old('branding.donate_url', $branding['donate_url'] ?? '/donate') }}" class="field-input mt-2">
                </label>
            </div>
        </div>

        <div class="mt-8 rounded-lg border border-sand p-4">
            <h2 class="text-2xl">WhatsApp Floating Button</h2>
            <p class="mt-1 text-sm text-slate/70">Show a WhatsApp chat button at the bottom-right of every public page.</p>
            <div class="mt-4">
                <label class="inline-flex items-center gap-2 rounded-full bg-mist px-4 py-2 text-sm font-bold text-pine">
                    <input type="checkbox" name="whatsapp[enabled]" value="1" @checked(old('whatsapp.enabled', $whatsapp['enabled'] ?? false))>
                    Enable WhatsApp button
                </label>
            </div>
            <div class="mt-4 grid gap-5 md:grid-cols-2">
                <label class="block">
                    <span class="text-sm font-bold text-pine">WhatsApp Phone Number</span>
                    <input name="whatsapp[phone]" value="{{ old('whatsapp.phone', $whatsapp['phone'] ?? '') }}" class="field-input mt-2" placeholder="+254115679375">
                </label>
                <label class="block">
                    <span class="text-sm font-bold text-pine">Button Label</span>
                    <input name="whatsapp[label]" value="{{ old('whatsapp.label', $whatsapp['label'] ?? 'Chat on WhatsApp') }}" class="field-input mt-2">
                </label>
                <label class="block md:col-span-2">
                    <span class="text-sm font-bold text-pine">Default WhatsApp Message</span>
                    <textarea name="whatsapp[message]" rows="3" class="field-input mt-2">{{ old('whatsapp.message', $whatsapp['message'] ?? '') }}</textarea>
                </label>
            </div>
        </div>

        <div class="mt-8 flex flex-wrap justify-end gap-3">
            <a href="{{ route('admin.dashboard') }}" class="rounded-full border border-sand px-6 py-3 text-sm font-bold text-slate hover:bg-mist">Cancel</a>
            <button type="submit" class="rounded-full bg-pine px-6 py-3 text-sm font-bold text-white hover:bg-sage">Save Branding</button>
        </div>
    </form>
@endsection
