@extends('layouts.admin', ['title' => $mode === 'create' ? 'Add Book' : 'Edit Book'])

@section('content')
    <a href="{{ route('admin.books.index') }}" class="text-sm font-bold text-pine hover:text-sage">Back to books</a>
    <h1 class="mt-2 text-4xl">{{ $mode === 'create' ? 'Add Book Product' : 'Edit Book Product' }}</h1>

    @if ($errors->any())
        <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ $errors->first() }}
        </div>
    @endif

    <form
        method="POST"
        action="{{ $mode === 'create' ? route('admin.books.store') : route('admin.books.update', $book['slug']) }}"
        enctype="multipart/form-data"
        class="mt-7 grid gap-6"
    >
        @csrf
        @if ($mode === 'edit')
            @method('PUT')
        @endif

        <section class="rounded-lg border border-sand bg-white p-5">
            <h2 class="text-2xl">Book Details</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Title *</span>
                    <input name="title" value="{{ old('title', $book['title']) }}" class="field-input" required>
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Slug</span>
                    <input name="slug" value="{{ old('slug', $book['slug']) }}" class="field-input" placeholder="auto-generated if blank">
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Author</span>
                    <input name="author" value="{{ old('author', $book['author']) }}" class="field-input">
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Category</span>
                    <input name="category" value="{{ old('category', $book['category']) }}" class="field-input">
                </label>
                <label class="grid gap-2 md:col-span-2">
                    <span class="text-sm font-bold text-pine">Description *</span>
                    <textarea name="description" rows="4" class="field-input" required>{{ old('description', $book['description']) }}</textarea>
                </label>
            </div>
        </section>

        <section class="rounded-lg border border-sand bg-white p-5">
            <h2 class="text-2xl">Pricing and Purchase</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-3">
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Price</span>
                    <input type="number" step="0.01" min="0" name="price" value="{{ old('price', $book['price']) }}" class="field-input">
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Currency</span>
                    <input name="currency" value="{{ old('currency', $book['currency']) }}" maxlength="3" class="field-input" required>
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Format</span>
                    <select name="format" class="field-input" required>
                        @foreach (['pdf' => 'PDF', 'print' => 'Print', 'both' => 'PDF and Print'] as $value => $label)
                            <option value="{{ $value }}" @selected(old('format', $book['format']) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                </label>
                <label class="grid gap-2 md:col-span-3">
                    <span class="text-sm font-bold text-pine">Purchase URL</span>
                    <input name="purchase_url" value="{{ old('purchase_url', $book['purchase_url']) }}" class="field-input" placeholder="/donate or external payment link">
                </label>
                <label class="grid gap-2 md:col-span-3">
                    <span class="text-sm font-bold text-pine">PDF URL or Path</span>
                    <input name="pdf_url" value="{{ old('pdf_url', $book['pdf_url']) }}" class="field-input" placeholder="/storage/books/file.pdf or secured delivery link">
                </label>
                <label class="inline-flex items-center gap-2 rounded-full bg-mist px-4 py-2 text-sm font-bold text-pine">
                    <input type="checkbox" name="is_available" value="1" @checked(old('is_available', $book['is_available']))>
                    Available in shop
                </label>
            </div>
        </section>

        <section class="rounded-lg border border-sand bg-white p-5">
            <h2 class="text-2xl">Cover Image</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-[1fr_auto] md:items-end">
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Cover Image URL or Path</span>
                    <input name="cover_image" value="{{ old('cover_image', $book['cover_image']) }}" class="field-input">
                    <input type="file" name="cover_upload" accept="image/*" class="field-input bg-white">
                    <span class="text-xs font-semibold text-slate/60">Maximum upload size: 20 MB.</span>
                </label>
                @if (!empty($book['cover_image']))
                    <img src="{{ $book['cover_image'] }}" alt="{{ $book['title'] }}" class="h-32 w-24 object-cover">
                @endif
            </div>
        </section>

        <div class="sticky bottom-0 z-20 -mx-4 border-t border-sand bg-cream/95 px-4 py-4 backdrop-blur sm:mx-0 sm:rounded-lg sm:border">
            <div class="flex flex-wrap justify-end gap-3">
                <a href="{{ route('admin.books.index') }}" class="rounded-full border border-sand bg-white px-5 py-3 text-sm font-bold text-slate hover:bg-mist">Cancel</a>
                <button type="submit" class="rounded-full bg-pine px-6 py-3 text-sm font-bold text-white hover:bg-sage">
                    {{ $mode === 'create' ? 'Create Book' : 'Save Book' }}
                </button>
            </div>
        </div>
    </form>
@endsection
