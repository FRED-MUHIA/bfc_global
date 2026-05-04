@extends('layouts.admin', ['title' => 'Media Library'])

@section('content')
    <div class="mb-6">
        <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-pine hover:text-ember">Back to dashboard</a>
        <h1 class="mt-3 text-4xl">Media Library</h1>
        <p class="mt-2 max-w-3xl text-slate/75">Upload images, PDFs, or short media files and use the generated link anywhere in the page builder or settings.</p>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.media.store') }}" enctype="multipart/form-data" class="rounded-lg border border-sand bg-white p-5">
        @csrf
        <h2 class="text-2xl">Upload Media</h2>
        <div class="mt-5 grid gap-4 md:grid-cols-[1fr_1fr_auto] md:items-end">
            <label class="grid gap-2">
                <span class="text-sm font-bold text-pine">Display Name</span>
                <input name="name" value="{{ old('name') }}" class="field-input" placeholder="Homepage hero image">
            </label>
            <label class="grid gap-2">
                <span class="text-sm font-bold text-pine">File</span>
                <input type="file" name="media" accept="image/*,.pdf,video/mp4,video/quicktime,video/webm" class="block w-full rounded-lg border border-sand bg-white px-4 py-3 text-sm" required>
            </label>
            <button type="submit" class="rounded-full bg-pine px-6 py-3 text-sm font-bold text-white hover:bg-sage">Upload</button>
        </div>
        <p class="mt-3 text-sm text-slate/65">Maximum file size: 5 MB.</p>
    </form>

    <section class="mt-8">
        <div class="mb-4 flex flex-wrap items-center justify-between gap-3">
            <h2 class="text-2xl">Uploaded Files</h2>
            <p class="text-sm text-slate/65">{{ $assets->total() }} file(s)</p>
        </div>

        <div class="grid gap-5 md:grid-cols-2 xl:grid-cols-3">
            @forelse ($assets as $asset)
                @php($fullUrl = url($asset->url))
                <article class="overflow-hidden rounded-lg border border-sand bg-white">
                    @if ($asset->isImage())
                        <img src="{{ $asset->url }}" alt="{{ $asset->name }}" class="h-52 w-full object-cover">
                    @else
                        <div class="flex h-52 items-center justify-center bg-mist px-5 text-center">
                            <span class="rounded-full bg-white px-4 py-2 text-sm font-bold text-pine">{{ $asset->mime_type ?? 'File' }}</span>
                        </div>
                    @endif
                    <div class="p-4">
                        <h3 class="text-xl leading-tight text-pine">{{ $asset->name }}</h3>
                        <p class="mt-1 text-xs text-slate/65">{{ $asset->original_name }} - {{ $asset->formattedSize() }}</p>
                        <input readonly value="{{ $fullUrl }}" class="mt-4 w-full rounded-lg border border-sand bg-cream px-3 py-2 text-xs text-slate" data-media-url>
                        <div class="mt-4 flex flex-wrap gap-2">
                            <button type="button" class="rounded-full bg-pine px-4 py-2 text-sm font-bold text-white hover:bg-sage" data-copy-media="{{ $fullUrl }}">Copy Link</button>
                            <a href="{{ $asset->url }}" target="_blank" rel="noopener" class="rounded-full border border-sand px-4 py-2 text-sm font-bold text-slate hover:bg-mist">Open</a>
                            <form method="POST" action="{{ route('admin.media.destroy', $asset) }}" onsubmit="return confirm('Delete this media file?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="rounded-full border border-red-200 px-4 py-2 text-sm font-bold text-red-700 hover:bg-red-50">Delete</button>
                            </form>
                        </div>
                    </div>
                </article>
            @empty
                <p class="rounded-lg border border-sand bg-white p-5 text-slate/70 md:col-span-2 xl:col-span-3">No media uploaded yet.</p>
            @endforelse
        </div>

        <div class="mt-6">
            {{ $assets->links() }}
        </div>
    </section>

    <script>
        document.querySelectorAll('[data-copy-media]').forEach((button) => {
            button.addEventListener('click', async () => {
                await navigator.clipboard.writeText(button.dataset.copyMedia);
                const original = button.textContent;
                button.textContent = 'Copied';
                window.setTimeout(() => {
                    button.textContent = original;
                }, 1400);
            });
        });
    </script>
@endsection
