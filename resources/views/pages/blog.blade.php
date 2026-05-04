@extends('layouts.app', [
    'title' => 'Blog',
    'description' => 'Read encouragement, practical tips, and thought leadership on parenting, marriage, youth mentorship, counseling, and community care.',
])

@section('content')
    @php
        $blogPosts = ($posts ?? collect())->isNotEmpty()
            ? $posts
            : collect($site['blog_posts'] ?? [])->map(fn ($post) => (object) $post);
    @endphp

    @include('partials.page-header', [
        'eyebrow' => 'Blog',
        'headerTitle' => 'Insight and encouragement for family and community life',
        'headerDescription' => 'Explore articles from our team of practitioners, counselors, and community leaders.',
        'primaryAction' => ['label' => 'Contact Us', 'to' => '/contact'],
        'secondaryAction' => ['label' => 'Get Involved', 'to' => '/get-involved'],
    ])

    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="mb-10 max-w-3xl">
                <h2 class="text-3xl leading-tight md:text-4xl">Latest Articles</h2>
            </div>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($blogPosts as $post)
                    <article class="overflow-hidden rounded-3xl border border-sand bg-white shadow-soft transition hover:-translate-y-1">
                        <img src="{{ $post->image }}" alt="{{ $post->title }}" class="h-52 w-full object-cover" loading="lazy">
                        <div class="p-6">
                            <p class="text-xs font-bold uppercase tracking-[0.12em] text-ember">{{ $post->category }}</p>
                            <h3 class="mt-2 text-2xl leading-tight">{{ $post->title }}</h3>
                            <p class="mt-3 text-sm text-slate/80">{{ $post->excerpt }}</p>
                            <p class="mt-4 text-xs text-slate/60">
                                {{ $post->date_label ?? $post->date }} • {{ $post->read_time }}
                            </p>
                            <a href="{{ route('blog.show', $post->slug) }}" class="mt-5 inline-flex text-sm font-semibold text-pine transition hover:text-ember">
                                Read article →
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white/70 py-16 md:py-20">
        <div class="container-base">
            <div class="mb-10 max-w-3xl">
                <h2 class="text-3xl leading-tight md:text-4xl">Never Miss an Update</h2>
            </div>
            @include('partials.newsletter-form')
        </div>
    </section>
@endsection
