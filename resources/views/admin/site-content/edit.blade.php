@extends('layouts.admin', ['title' => 'Site Content'])

@section('content')
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-pine hover:text-sage">Back to dashboard</a>
            <h1 class="mt-2 text-4xl">Global Site Content</h1>
            <p class="mt-2 max-w-3xl text-slate/75">
                This is the editable content source used by the frontend for shared copy, images, menus, program cards, gallery items, resource cards, testimonials, contact details, and fallback blog content.
            </p>
        </div>
    </div>

    @if ($errors->any())
        <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.site-content.update') }}" class="mt-7 grid gap-5">
        @csrf
        @method('PUT')

        <section class="rounded-lg border border-sand bg-white p-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-2xl">Editable JSON</h2>
                <p class="text-sm font-semibold text-slate/65">Use image URLs or local paths in any image field.</p>
            </div>

            <label class="mt-4 block">
                <span class="sr-only">Site JSON</span>
                <textarea name="site_json" rows="32" spellcheck="false" class="field-input font-mono text-xs leading-relaxed">{{ old('site_json', $siteJson) }}</textarea>
            </label>
        </section>

        <div class="sticky bottom-0 z-20 -mx-4 border-t border-sand bg-cream/95 px-4 py-4 backdrop-blur sm:mx-0 sm:rounded-lg sm:border">
            <div class="flex flex-wrap justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="rounded-full border border-sand bg-white px-5 py-3 text-sm font-bold text-slate hover:bg-mist">Cancel</a>
                <button type="submit" class="rounded-full bg-pine px-6 py-3 text-sm font-bold text-white hover:bg-sage">Save Site Content</button>
            </div>
        </div>
    </form>
@endsection
