@extends('layouts.app', [
    'title' => $post->title,
    'description' => $post->excerpt,
])

@section('content')
    <article class="pb-16">
        <header class="relative overflow-hidden bg-gradient-to-br from-pine via-sage to-pine py-20 text-white">
            <div class="pointer-events-none absolute -right-20 top-0 h-72 w-72 rounded-full bg-ember/20 blur-3xl"></div>
            <div class="container-base relative">
                <a href="{{ route('blog.index') }}" class="text-sm font-semibold uppercase tracking-[0.14em] text-cream/80 hover:text-white">
                    ← Back to Blog
                </a>
                <p class="mt-8 text-xs font-bold uppercase tracking-[0.13em] text-cream/80">{{ $post->category }}</p>
                <h1 class="mt-3 max-w-4xl text-4xl leading-tight text-white md:text-5xl">{{ $post->title }}</h1>
                <p class="mt-5 text-sm text-cream/85">
                    By {{ $post->author }} • {{ $post->date_label }} • {{ $post->read_time }}
                </p>
            </div>
        </header>

        <div class="container-base mt-10">
            <img src="{{ $post->image }}" alt="{{ $post->title }}" class="h-72 w-full rounded-3xl object-cover shadow-soft md:h-[28rem]" loading="eager" fetchpriority="high" decoding="async" sizes="100vw">
        </div>

        <div class="container-base mt-10 grid gap-8">
            @foreach ($post->content as $section)
                <section class="glass-panel p-6 md:p-8">
                    <h2 class="text-2xl">{{ $section['heading'] }}</h2>
                    <div class="mt-4 grid gap-4">
                        @foreach ($section['paragraphs'] as $paragraph)
                            <p class="text-slate/85">{{ $paragraph }}</p>
                        @endforeach
                    </div>
                </section>
            @endforeach
        </div>
    </article>

    @include('partials.cta-banner', [
        'bannerTitle' => 'Need personalized support for your family?',
        'bannerDescription' => 'Our team can connect you to counseling, mentoring, workshops, and trusted local resources.',
        'primaryAction' => ['label' => 'Contact Us', 'to' => '/contact'],
        'secondaryAction' => ['label' => 'Explore Programs', 'to' => '/ministry-programs'],
    ])
@endsection
