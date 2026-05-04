@extends('layouts.admin', ['title' => $mode === 'create' ? 'Add Blog Post' : 'Edit Blog Post'])

@section('content')
    <a href="{{ route('admin.blog.index') }}" class="text-sm font-bold text-pine hover:text-ember">Back to blog posts</a>
    <h1 class="mt-3 text-4xl">{{ $mode === 'create' ? 'Add Blog Post' : 'Edit Blog Post' }}</h1>

    @if ($errors->any())
        <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ $errors->first() }}
        </div>
    @endif

    <form method="POST" action="{{ $mode === 'create' ? route('admin.blog.store') : route('admin.blog.update', $post) }}" enctype="multipart/form-data" class="mt-7 grid gap-6">
        @csrf
        @if ($mode === 'edit')
            @method('PUT')
        @endif

        <section class="rounded-lg border border-sand bg-white p-5">
            <h2 class="text-2xl">Post Details</h2>
            <div class="mt-5 grid gap-4 md:grid-cols-2">
                <label class="grid gap-2 md:col-span-2">
                    <span class="text-sm font-bold text-pine">Title</span>
                    <input name="title" value="{{ old('title', $post->title) }}" class="field-input" required>
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Slug</span>
                    <input name="slug" value="{{ old('slug', $post->slug) }}" class="field-input" placeholder="Auto-generated if empty">
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Category</span>
                    <input name="category" value="{{ old('category', $post->category) }}" class="field-input" required>
                </label>
                <label class="grid gap-2 md:col-span-2">
                    <span class="text-sm font-bold text-pine">Excerpt</span>
                    <textarea name="excerpt" rows="3" class="field-input" required>{{ old('excerpt', $post->excerpt) }}</textarea>
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Author</span>
                    <input name="author" value="{{ old('author', $post->author) }}" class="field-input" required>
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Published Date</span>
                    <input type="date" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d') ?? now()->format('Y-m-d')) }}" class="field-input" required>
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Date Label</span>
                    <input name="date_label" value="{{ old('date_label', $post->date_label) }}" class="field-input" placeholder="January 15, 2026">
                </label>
                <label class="grid gap-2">
                    <span class="text-sm font-bold text-pine">Read Time</span>
                    <input name="read_time" value="{{ old('read_time', $post->read_time) }}" class="field-input" required>
                </label>
                <label class="grid gap-2 md:col-span-2">
                    <span class="text-sm font-bold text-pine">Image URL</span>
                    <input name="image" value="{{ old('image', $post->image) }}" class="field-input">
                </label>
                <label class="grid gap-2 md:col-span-2">
                    <span class="text-sm font-bold text-pine">Upload Image</span>
                    <input type="file" name="image_upload" accept="image/*" class="block w-full rounded-lg border border-sand bg-white px-4 py-3 text-sm">
                </label>
            </div>
        </section>

        <section class="rounded-lg border border-sand bg-white p-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-2xl">Article Sections</h2>
                <button type="button" data-add-blog-section class="rounded-full bg-ember px-4 py-2 text-sm font-bold text-white hover:bg-ember/90">Add Section</button>
            </div>
            <div class="mt-5 grid gap-4" data-blog-sections>
                @foreach (old('content', $post->content ?? []) as $index => $section)
                    @php($paragraphs = $section['paragraphs_text'] ?? implode("\n\n", $section['paragraphs'] ?? []))
                    <div class="rounded-lg border border-sand bg-cream/40 p-4" data-blog-section>
                        <div class="flex items-center justify-between gap-3">
                            <p class="text-sm font-bold text-pine">Section</p>
                            <button type="button" data-remove-blog-section class="rounded-full border border-sand px-3 py-1 text-xs font-bold text-pine hover:bg-mist">Remove</button>
                        </div>
                        <label class="mt-3 grid gap-2">
                            <span class="text-sm font-bold text-pine">Heading</span>
                            <input name="content[{{ $index }}][heading]" value="{{ $section['heading'] ?? '' }}" class="field-input" required>
                        </label>
                        <label class="mt-3 grid gap-2">
                            <span class="text-sm font-bold text-pine">Paragraphs</span>
                            <textarea name="content[{{ $index }}][paragraphs_text]" rows="7" class="field-input" required>{{ $paragraphs }}</textarea>
                        </label>
                    </div>
                @endforeach
            </div>
        </section>

        <div class="sticky bottom-0 z-20 -mx-4 border-t border-sand bg-cream/95 px-4 py-4 backdrop-blur sm:mx-0 sm:rounded-lg sm:border">
            <div class="flex justify-end gap-3">
                <a href="{{ route('admin.blog.index') }}" class="rounded-full border border-sand bg-white px-5 py-3 text-sm font-bold text-slate hover:bg-mist">Cancel</a>
                <button type="submit" class="rounded-full bg-pine px-6 py-3 text-sm font-bold text-white hover:bg-sage">Save Blog Post</button>
            </div>
        </div>
    </form>

    <template data-blog-section-template>
        <div class="rounded-lg border border-sand bg-cream/40 p-4" data-blog-section>
            <div class="flex items-center justify-between gap-3">
                <p class="text-sm font-bold text-pine">Section</p>
                <button type="button" data-remove-blog-section class="rounded-full border border-sand px-3 py-1 text-xs font-bold text-pine hover:bg-mist">Remove</button>
            </div>
            <label class="mt-3 grid gap-2">
                <span class="text-sm font-bold text-pine">Heading</span>
                <input data-name="heading" class="field-input" required>
            </label>
            <label class="mt-3 grid gap-2">
                <span class="text-sm font-bold text-pine">Paragraphs</span>
                <textarea data-name="paragraphs_text" rows="7" class="field-input" required></textarea>
            </label>
        </div>
    </template>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const list = document.querySelector('[data-blog-sections]');
            const template = document.querySelector('[data-blog-section-template]');

            const reindex = () => {
                list.querySelectorAll('[data-blog-section]').forEach((section, index) => {
                    section.querySelectorAll('[data-name], [name]').forEach((field) => {
                        const key = field.dataset.name || field.name.match(/\]\[(.+)\]/)?.[1];
                        if (key) field.name = `content[${index}][${key}]`;
                    });
                });
            };

            document.querySelector('[data-add-blog-section]')?.addEventListener('click', () => {
                list.appendChild(template.content.cloneNode(true));
                reindex();
            });

            list.addEventListener('click', (event) => {
                if (event.target.closest('[data-remove-blog-section]')) {
                    event.target.closest('[data-blog-section]')?.remove();
                    reindex();
                }
            });
        });
    </script>
@endsection
