@extends('layouts.app', [
    'title' => 'Home',
    'description' => 'Faith-rooted family and community support with parenting resources, counseling, youth mentoring, and practical outreach.',
])

@section('content')
    @php
        $previews = ($blogPreviews ?? collect())->isNotEmpty()
            ? $blogPreviews
            : collect($site['blog_posts'] ?? [])->take(3)->map(fn ($post) => (object) $post);
        $homeAbout = $site['home_about'] ?? [];
        $homeSections = $site['home_sections'] ?? [];
    @endphp

    <div class="pt-2 md:pt-3">
        @include('partials.hero-slider', ['slides' => $site['home_hero_slides'] ?? []])
    </div>

    <section class="bg-white/70 py-16 md:py-20">
        <div class="container-base">
            <div class="grid items-center gap-10 lg:grid-cols-[1.02fr_0.98fr]">
                <div class="reveal-item max-w-2xl" data-reveal>
                    <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">{{ $homeAbout['eyebrow'] ?? 'About Us' }}</p>
                    <h2 class="mt-3 text-3xl leading-tight md:text-4xl">{{ $homeAbout['title'] ?? 'Building families, touching communities, changing the world' }}</h2>
                    <p class="mt-5 text-base leading-8 text-slate/85 md:text-lg">
                        {{ $site['organization']['about_intro'] }}
                    </p>
                    <blockquote class="reveal-item mt-6 rounded-3xl border-l-4 border-ember bg-cream/80 p-5 shadow-soft" data-reveal style="--reveal-delay: 120ms;">
                        <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">{{ $homeAbout['scripture_reference'] ?? 'Nehemiah 2:18' }}</p>
                        <p class="mt-3 text-base italic leading-8 text-slate/85">
                            {{ $homeAbout['scripture_text'] ?? '' }}
                        </p>
                    </blockquote>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ url($homeAbout['primary_url'] ?? '/about') }}" class="inline-flex items-center justify-center rounded-full bg-pine px-6 py-3 text-base font-semibold tracking-wide text-white transition hover:bg-sage">
                            {{ $homeAbout['primary_label'] ?? 'Learn More' }}
                        </a>
                        <a href="{{ url($homeAbout['secondary_url'] ?? '/contact') }}" class="inline-flex items-center justify-center rounded-full border border-sage/30 px-6 py-3 text-base font-semibold tracking-wide text-pine transition hover:bg-sage/10">
                            {{ $homeAbout['secondary_label'] ?? 'Contact Us' }}
                        </a>
                    </div>
                </div>
                <div class="reveal-item float-soft overflow-hidden rounded-3xl shadow-soft" data-reveal style="--reveal-delay: 180ms;">
                    <img
                        src="{{ $homeAbout['image'] ?? 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=1200&q=80' }}"
                        alt="{{ $homeAbout['image_alt'] ?? 'Families and community members gathered in support' }}"
                        class="h-80 w-full object-cover md:h-[28rem]"
                        loading="lazy"
                        decoding="async"
                        sizes="(min-width: 1024px) 49vw, 100vw"
                    >
                </div>
            </div>
        </div>
    </section>

    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="reveal-item mb-10 max-w-3xl" data-reveal>
                <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">{{ data_get($homeSections, 'featured_resources.eyebrow', 'Featured Resources') }}</p>
                <h2 class="mt-3 text-3xl leading-tight md:text-4xl">{{ data_get($homeSections, 'featured_resources.title', 'Practical tools for everyday family life') }}</h2>
                <p class="mt-4 text-base text-slate/80 md:text-lg">
                    {{ data_get($homeSections, 'featured_resources.description', 'Explore our most requested guides designed for busy parents, couples, and caregivers.') }}
                </p>
            </div>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @forelse (($featuredResourcePosts ?? collect()) as $post)
                    <a href="{{ route('blog.show', $post->slug) }}" class="reveal-item glass-panel block h-full p-6 transition hover:-translate-y-1 hover:shadow-soft focus:outline-none focus:ring-2 focus:ring-sage/30" data-reveal style="--reveal-delay: {{ $loop->index * 100 }}ms;">
                        <h3 class="text-2xl leading-tight">{{ $post->title }}</h3>
                        <p class="mt-4 text-sm text-slate/80">{{ $post->excerpt }}</p>
                        <p class="mt-5 text-xs font-semibold uppercase tracking-[0.12em] text-ember">{{ $post->read_time }}</p>
                    </a>
                @empty
                    @foreach (($site['featured_resources'] ?? []) as $resource)
                    @php
                        $candidateBlogSlug = $resource['blog_slug'] ?? str($resource['title'] ?? '')->slug()->toString();
                        $resourceUrl = in_array($candidateBlogSlug, $blogSlugs ?? [], true)
                            ? route('blog.show', $candidateBlogSlug)
                            : route('blog.index');
                    @endphp
                    <a href="{{ $resourceUrl }}" class="reveal-item glass-panel block h-full p-6 transition hover:-translate-y-1 hover:shadow-soft focus:outline-none focus:ring-2 focus:ring-sage/30" data-reveal style="--reveal-delay: {{ $loop->index * 100 }}ms;">
                        <p class="text-xs font-bold uppercase tracking-[0.13em] text-sage">{{ $resource['category'] }}</p>
                        <h3 class="mt-3 text-2xl leading-tight">{{ $resource['title'] }}</h3>
                        <p class="mt-4 text-sm text-slate/80">{{ $resource['description'] }}</p>
                        <p class="mt-5 text-xs font-semibold uppercase tracking-[0.12em] text-ember">{{ $resource['read_time'] }}</p>
                    </a>
                    @endforeach
                @endforelse
            </div>
        </div>
    </section>

    <section class="bg-white/70 py-16 md:py-20">
        <div class="container-base">
            <div class="reveal-item mb-10 max-w-3xl" data-reveal>
                <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">{{ data_get($homeSections, 'impact.eyebrow', 'Our Impact') }}</p>
                <h2 class="mt-3 text-3xl leading-tight md:text-4xl">{{ data_get($homeSections, 'impact.title', 'Serving families with measurable care') }}</h2>
                <p class="mt-4 text-base text-slate/80 md:text-lg">
                    {{ data_get($homeSections, 'impact.description', 'By combining compassionate support with practical programs, we are seeing meaningful outcomes across communities.') }}
                </p>
            </div>
            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach (($site['impact_stats'] ?? []) as $stat)
                    @php
                        $statStyles = [
                            'bg-pine text-white border-pine',
                            'bg-ember text-white border-ember',
                            'bg-sage text-white border-sage',
                            'bg-mist text-pine border-sage/20',
                        ];
                        $labelStyles = [
                            'text-white/85',
                            'text-white/90',
                            'text-white/85',
                            'text-sage',
                        ];
                    @endphp
                    <article class="reveal-item rounded-2xl border p-6 text-center shadow-soft transition hover:-translate-y-1 {{ $statStyles[$loop->index % count($statStyles)] }}" data-reveal style="--reveal-delay: {{ $loop->index * 80 }}ms;">
                        <p class="text-4xl font-bold md:text-5xl">{{ $stat['value'] }}</p>
                        <p class="mt-3 text-sm font-semibold uppercase tracking-[0.11em] {{ $labelStyles[$loop->index % count($labelStyles)] }}">{{ $stat['label'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="reveal-item mb-10 max-w-3xl" data-reveal>
                <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">{{ data_get($homeSections, 'testimonials.eyebrow', 'Stories of Hope') }}</p>
                <h2 class="mt-3 text-3xl leading-tight md:text-4xl">{{ data_get($homeSections, 'testimonials.title', 'Families sharing real transformation') }}</h2>
                <p class="mt-4 text-base text-slate/80 md:text-lg">
                    {{ data_get($homeSections, 'testimonials.description', 'Every testimony reflects resilience, renewed trust, and a stronger sense of belonging.') }}
                </p>
            </div>
            <div class="relative" data-testimonial-slider>
                <div class="overflow-hidden">
                    <div class="flex transition-transform duration-500 ease-out" data-testimonial-track>
                @foreach (($site['testimonials'] ?? []) as $testimonial)
                    @php
                        $quoteSentences = preg_split('/(?<=[.!?])\s+/', trim($testimonial['quote'] ?? ''), -1, PREG_SPLIT_NO_EMPTY);
                        $quotePreview = implode(' ', array_slice($quoteSentences ?: [$testimonial['quote'] ?? ''], 0, 2));
                    @endphp
                    <article class="reveal-item min-w-full px-0 md:min-w-[50%] md:px-3 lg:min-w-[33.333%]" data-reveal style="--reveal-delay: {{ $loop->index * 100 }}ms;">
                        <button type="button" data-testimonial-open="home-testimonial-{{ $loop->index }}" class="group glass-panel flex h-full w-full flex-col p-6 text-left transition hover:-translate-y-1 hover:shadow-soft focus:outline-none focus:ring-2 focus:ring-sage/30">
                            <div class="flex w-full items-center gap-4 border-b border-sand pb-4">
                                <img src="{{ $testimonial['image'] }}" alt="{{ $testimonial['name'] }}" class="h-14 w-14 shrink-0 rounded-full object-cover ring-2 ring-white shadow" loading="lazy" decoding="async" sizes="56px">
                                <div>
                                    <p class="font-semibold text-pine">{{ $testimonial['name'] }}</p>
                                    <p class="text-sm text-slate/70">{{ $testimonial['role'] }}</p>
                                </div>
                            </div>
                            <p class="mt-5 text-lg leading-relaxed text-slate/90">"{{ $quotePreview }}"</p>
                            <span class="mt-3 inline-flex text-sm font-bold uppercase tracking-[0.12em] text-ember underline-offset-4 transition group-hover:text-pine group-hover:underline group-focus:underline">Read more</span>
                        </button>
                    </article>

                @endforeach
                    </div>
                </div>
                <div class="mt-6 flex items-center justify-center gap-3">
                    <button type="button" data-testimonial-prev class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-sand bg-white text-pine transition hover:bg-mist" aria-label="Previous testimonial">
                        &larr;
                    </button>
                    <button type="button" data-testimonial-next class="inline-flex h-11 w-11 items-center justify-center rounded-full border border-sand bg-white text-pine transition hover:bg-mist" aria-label="Next testimonial">
                        &rarr;
                    </button>
                </div>
            </div>
        </div>
    </section>

    @foreach (($site['testimonials'] ?? []) as $testimonial)
        <div id="home-testimonial-{{ $loop->index }}" data-testimonial-modal class="fixed inset-0 z-[90] hidden items-center justify-center bg-slate/70 px-4 py-6 backdrop-blur-sm" role="dialog" aria-modal="true" aria-labelledby="home-testimonial-title-{{ $loop->index }}">
            <div class="max-h-[88vh] w-full max-w-2xl overflow-y-auto rounded-3xl bg-white p-6 shadow-2xl md:p-8">
                <div class="sticky top-0 z-10 -mx-6 -mt-6 flex items-start justify-between gap-4 border-b border-sand bg-white/95 px-6 py-5 backdrop-blur md:-mx-8 md:-mt-8 md:px-8">
                    <div class="flex items-center gap-4">
                        <img src="{{ $testimonial['image'] }}" alt="{{ $testimonial['name'] }}" class="h-16 w-16 shrink-0 rounded-full object-cover ring-2 ring-sand" loading="lazy" decoding="async" sizes="64px">
                        <div>
                            <h3 id="home-testimonial-title-{{ $loop->index }}" class="text-2xl">{{ $testimonial['name'] }}</h3>
                            <p class="text-sm font-semibold uppercase tracking-[0.12em] text-sage">{{ $testimonial['role'] }}</p>
                        </div>
                    </div>
                    <button type="button" data-testimonial-close class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-sand text-2xl text-pine transition hover:bg-mist" aria-label="Close testimonial">&times;</button>
                </div>
                <p class="mt-6 text-lg leading-8 text-slate/90">"{{ $testimonial['quote'] }}"</p>
                <p class="mt-4 text-base leading-8 text-slate/80">{{ $testimonial['detail'] }}</p>
            </div>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const slider = document.querySelector('[data-testimonial-slider]');
            if (!slider) return;

            const track = slider.querySelector('[data-testimonial-track]');
            const slides = Array.from(track.children).filter((child) => child.matches('article'));
            const prev = slider.querySelector('[data-testimonial-prev]');
            const next = slider.querySelector('[data-testimonial-next]');
            let index = 0;

            const visibleCount = () => {
                if (window.matchMedia('(min-width: 1024px)').matches) return 3;
                if (window.matchMedia('(min-width: 768px)').matches) return 2;
                return 1;
            };

            const render = () => {
                const maxIndex = Math.max(0, slides.length - visibleCount());
                index = Math.min(index, maxIndex);
                track.style.transform = `translateX(-${index * (100 / visibleCount())}%)`;
                prev.disabled = index === 0;
                next.disabled = index === maxIndex;
                prev.classList.toggle('opacity-40', prev.disabled);
                next.classList.toggle('opacity-40', next.disabled);
            };

            prev?.addEventListener('click', () => {
                index = Math.max(0, index - 1);
                render();
            });

            next?.addEventListener('click', () => {
                index += 1;
                render();
            });

            window.addEventListener('resize', render);
            render();
        });
    </script>

    <section class="bg-white/60 py-16 md:py-20">
        <div class="container-base">
            <div class="reveal-item mb-10 max-w-3xl" data-reveal>
                <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">{{ data_get($homeSections, 'blog.eyebrow', 'Latest from Our Blog') }}</p>
                <h2 class="mt-3 text-3xl leading-tight md:text-4xl">{{ data_get($homeSections, 'blog.title', 'Encouragement and insight for your next step') }}</h2>
                <p class="mt-4 text-base text-slate/80 md:text-lg">
                    {{ data_get($homeSections, 'blog.description', 'Read articles from our team on parenting, marriage, youth development, and community wellbeing.') }}
                </p>
            </div>
            <div class="grid gap-6 lg:grid-cols-3">
                @foreach ($previews as $post)
                    <article class="reveal-item overflow-hidden rounded-3xl border border-sand bg-white shadow-soft transition hover:-translate-y-1" data-reveal style="--reveal-delay: {{ $loop->index * 100 }}ms;">
                        <img src="{{ $post->image }}" alt="{{ $post->title }}" class="h-52 w-full object-cover" loading="lazy" decoding="async" sizes="(min-width: 1024px) 33vw, 100vw">
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
            <div class="mt-8">
                <a href="{{ route('blog.index') }}" class="text-sm font-semibold text-pine hover:text-ember">View all articles →</a>
            </div>
        </div>
    </section>

    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="reveal-item mb-10 max-w-3xl" data-reveal>
                <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">{{ data_get($homeSections, 'newsletter.eyebrow', 'Stay Connected') }}</p>
                <h2 class="mt-3 text-3xl leading-tight md:text-4xl">{{ data_get($homeSections, 'newsletter.title', 'Monthly support for your family journey') }}</h2>
                <p class="mt-4 text-base text-slate/80 md:text-lg">
                    {{ data_get($homeSections, 'newsletter.description', 'Receive practical encouragement, upcoming events, and free resources.') }}
                </p>
            </div>
            <div class="reveal-item" data-reveal style="--reveal-delay: 120ms;">
                @include('partials.newsletter-form')
            </div>
        </div>
    </section>

    @include('partials.cta-banner', [
        'bannerTitle' => 'Together we can build healthier homes and stronger communities.',
        'bannerDescription' => 'Partner with us through volunteering, sponsorship, prayer, or organizational collaboration.',
        'primaryAction' => ['label' => 'Get Involved', 'to' => '/get-involved'],
        'secondaryAction' => ['label' => 'Contact Our Team', 'to' => '/contact'],
    ])
@endsection
