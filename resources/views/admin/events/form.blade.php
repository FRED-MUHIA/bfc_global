@extends('layouts.admin', ['title' => $mode === 'create' ? 'Add Event' : 'Edit Event'])

@section('content')
    <a href="{{ route('admin.events.index') }}" class="text-sm font-bold text-pine hover:text-sage">Back to events</a>
    <h1 class="mt-2 text-4xl">{{ $mode === 'create' ? 'Add Event' : 'Edit Event' }}</h1>

    @if ($errors->any())
        <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ $errors->first() }}
        </div>
    @endif

    <form
        method="POST"
        action="{{ $mode === 'create' ? route('admin.events.store') : route('admin.events.update', $event['slug']) }}"
        enctype="multipart/form-data"
        class="mt-7 grid gap-6"
    >
        @csrf
        @if ($mode === 'edit')
            @method('PUT')
        @endif

        <section class="rounded-lg border border-sand bg-white p-5">
            <h2 class="text-2xl">Event Details</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Title *</span>
                    <input name="title" value="{{ old('title', $event['title']) }}" class="field-input" required>
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Slug</span>
                    <input name="slug" value="{{ old('slug', $event['slug']) }}" class="field-input" placeholder="auto-generated if blank">
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Date *</span>
                    <input name="date" value="{{ old('date', $event['date']) }}" class="field-input" required>
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Time *</span>
                    <input name="time" value="{{ old('time', $event['time']) }}" class="field-input" required>
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Venue *</span>
                    <input name="location" value="{{ old('location', $event['location']) }}" class="field-input" required>
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Category *</span>
                    <input name="category" value="{{ old('category', $event['category']) }}" class="field-input" required>
                </label>
                <label class="grid gap-2 md:col-span-2">
                    <span class="text-sm font-bold text-pine">Description *</span>
                    <textarea name="description" rows="4" class="field-input" required>{{ old('description', $event['description']) }}</textarea>
                </label>
                <label class="inline-flex items-center gap-2 rounded-full bg-mist px-4 py-2 text-sm font-bold text-pine">
                    <input type="checkbox" name="registration_open" value="1" class="h-4 w-4" @checked(old('registration_open', $event['registration_open'] ?? true))>
                    Open for registration
                </label>
            </div>
        </section>

        <section class="rounded-lg border border-sand bg-white p-5">
            <h2 class="text-2xl">Event Image</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-[1fr_auto] md:items-end">
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Image URL or Path</span>
                    <input name="image" value="{{ old('image', $event['image']) }}" class="field-input">
                    <input type="file" name="image_upload" accept="image/*" class="field-input bg-white">
                    <span class="text-xs font-semibold text-slate/60">Maximum upload size: 5 MB.</span>
                </label>
                @if (!empty($event['image']))
                    <img src="{{ $event['image'] }}" alt="{{ $event['title'] }}" class="h-28 w-40 rounded-lg object-cover">
                @endif
            </div>
        </section>

        <div class="sticky bottom-0 z-20 -mx-4 border-t border-sand bg-cream/95 px-4 py-4 backdrop-blur sm:mx-0 sm:rounded-lg sm:border">
            <div class="flex flex-wrap justify-end gap-3">
                <a href="{{ route('admin.events.index') }}" class="rounded-full border border-sand bg-white px-5 py-3 text-sm font-bold text-slate hover:bg-mist">Cancel</a>
                <button type="submit" class="rounded-full bg-pine px-6 py-3 text-sm font-bold text-white hover:bg-sage">
                    {{ $mode === 'create' ? 'Create Event' : 'Save Event' }}
                </button>
            </div>
        </div>
    </form>
@endsection
