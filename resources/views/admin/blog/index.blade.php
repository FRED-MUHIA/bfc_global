@extends('layouts.admin', ['title' => 'Blog Management'])

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-pine hover:text-ember">Back to dashboard</a>
            <h1 class="mt-3 text-4xl">Blog Management</h1>
            <p class="mt-2 text-slate/75">Create and edit blog posts independently from the page builder.</p>
        </div>
        <a href="{{ route('admin.blog.create') }}" class="rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">Add Blog Post</a>
    </div>

    @if ($errors->any())
        <div class="mb-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            {{ $errors->first() }}
        </div>
    @endif

    <section class="mb-6 rounded-lg border border-sand bg-white p-5">
        <div class="flex flex-wrap items-start justify-between gap-4">
            <div>
                <h2 class="text-2xl">Blog Categories</h2>
                <p class="mt-1 text-sm text-slate/70">Add categories for blog posts, or remove unused categories from the dropdown.</p>
            </div>
            <form method="POST" action="{{ route('admin.blog.categories.store') }}" class="flex flex-wrap gap-2">
                @csrf
                <input name="category" class="field-input min-w-64" placeholder="New category" required>
                <button type="submit" class="rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">Add Category</button>
            </form>
        </div>

        <div class="mt-5 flex flex-wrap gap-2">
            @forelse ($categories as $category)
                @php($postCount = $categoryPostCounts[$category] ?? 0)
                <div class="inline-flex items-center gap-2 rounded-full border border-sand bg-cream px-3 py-2 text-sm font-bold text-pine">
                    <span>{{ $category }}</span>
                    @if ($postCount > 0)
                        <span class="text-xs font-semibold text-slate/60">{{ $postCount }} post{{ $postCount === 1 ? '' : 's' }}</span>
                    @else
                        <form method="POST" action="{{ route('admin.blog.categories.destroy', $category) }}" onsubmit="return confirm('Remove this blog category?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-lg leading-none text-red-700 hover:text-red-900" aria-label="Remove {{ $category }}">&times;</button>
                        </form>
                    @endif
                </div>
            @empty
                <p class="text-sm text-slate/70">No categories yet.</p>
            @endforelse
        </div>
    </section>

    <div class="overflow-hidden rounded-lg border border-sand bg-white">
        <div class="divide-y divide-sand">
            @forelse ($posts as $post)
                <article class="grid gap-4 px-5 py-4 md:grid-cols-[7rem_1fr_auto] md:items-center">
                    <img src="{{ $post->image }}" alt="{{ $post->title }}" class="h-24 w-full rounded-lg object-cover md:w-28">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.12em] text-ember">{{ $post->category }}</p>
                        <h2 class="mt-1 text-2xl">{{ $post->title }}</h2>
                        <p class="mt-1 text-sm text-slate/70">{{ $post->date_label }} - {{ $post->read_time }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2">
                        <a href="{{ route('blog.show', $post->slug) }}" class="rounded-full border border-sand px-4 py-2 text-sm font-bold text-slate hover:bg-mist">Preview</a>
                        <a href="{{ route('admin.blog.edit', $post) }}" class="rounded-full bg-pine px-4 py-2 text-sm font-bold text-white hover:bg-sage">Edit</a>
                        <form method="POST" action="{{ route('admin.blog.destroy', $post) }}" onsubmit="return confirm('Delete this blog post?')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-full border border-red-200 px-4 py-2 text-sm font-bold text-red-700 hover:bg-red-50">Delete</button>
                        </form>
                    </div>
                </article>
            @empty
                <p class="px-5 py-8 text-center text-slate/70">No blog posts yet.</p>
            @endforelse
        </div>
    </div>

    <div class="mt-6">{{ $posts->links() }}</div>
@endsection
