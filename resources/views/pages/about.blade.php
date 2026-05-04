@extends('layouts.app', [
    'title' => 'About',
    'description' => 'Learn about the mission, vision, values, and discipleship mandate of Building Families and Community Global Trust.',
])

@section('content')
    @include('partials.page-header', [
        'eyebrow' => 'About Us',
        'headerTitle' => 'Building families, touching communities, changing the world',
        'headerDescription' => $site['organization']['about_intro'],
    ])

    <section class="py-16 md:py-20">
        <div class="container-base">
            <article class="mb-12 bg-white p-6 md:p-10">
                <h2 class="text-3xl leading-tight md:text-4xl">
                    <span class="font-bold text-pine">Message of the</span>
                    <span class="font-medium text-pine"> Founders</span>
                </h2>
                <div class="mt-10 grid items-center gap-8 lg:grid-cols-[18rem_1fr]">
                    <div class="relative mx-auto h-64 w-64 lg:mx-0">
                        <img
                            src="{{ $site['organization']['founders_message']['image'] }}"
                            alt="{{ $site['organization']['founders_message']['signature'] }}"
                            class="relative h-full w-full rounded-full object-cover shadow-soft"
                            loading="lazy"
                        >
                    </div>
                    <div class="text-pine">
                        <p class="text-lg font-bold">Greetings in the Lord's name!</p>
                        <div class="mt-5 grid gap-4 text-base leading-8 text-slate/85 md:text-lg">
                            @foreach (array_slice($site['organization']['founders_message']['paragraphs'], 0, 2) as $paragraph)
                                <p>{{ $paragraph }}</p>
                            @endforeach
                        </div>
                    </div>
                </div>
                <div class="mt-8 grid gap-4 text-base leading-8 text-slate/85 md:text-lg">
                    @foreach (array_slice($site['organization']['founders_message']['paragraphs'], 2) as $paragraph)
                        <p>{{ $paragraph }}</p>
                    @endforeach
                </div>
                <p class="mt-8 font-heading text-xl text-pine">{{ $site['organization']['founders_message']['signature'] }}</p>
            </article>
            <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">Who We Are</p>
                    <h2 class="mt-3 text-3xl leading-tight md:text-4xl">A Christian fellowship for family-based discipleship</h2>
                </div>
                <div class="glass-panel p-6 md:p-8">
                    <p class="text-base leading-8 text-slate/85 md:text-lg">{{ $site['organization']['about_intro'] }}</p>
                    <p class="mt-4 text-base leading-8 text-slate/80 md:text-lg">{{ $site['organization']['about_summary'] }}</p>
                </div>
            </div>
        </div>
    </section>

    <section class="bg-ember py-16 md:py-20">
        <div class="container-base">
            <div class="mb-10 max-w-3xl">
                <p class="text-sm font-extrabold uppercase tracking-[0.15em] text-white">Our Mandate</p>
                <h2 class="mt-3 text-3xl leading-tight text-white md:text-4xl">Build. Community. Global. Partnership.</h2>
            </div>
            <div class="grid gap-6 md:grid-cols-2">
                @foreach ($site['organization']['about_themes'] as $theme)
                    <article class="rounded-3xl border border-white bg-white p-6 shadow-soft md:p-8">
                        <h3 class="text-2xl">{{ $theme['title'] }}</h3>
                        <p class="mt-4 text-slate">{{ $theme['description'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="grid gap-6 md:grid-cols-2">
                <article class="glass-panel p-6 md:p-8">
                    <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">Our Mission</p>
                    <h2 class="mt-3 text-3xl leading-tight">Equipping families for influence</h2>
                    <p class="mt-4 text-slate/85">{{ $site['organization']['mission'] }}</p>
                </article>
                <article class="glass-panel p-6 md:p-8">
                    <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">Our Vision</p>
                    <h2 class="mt-3 text-3xl leading-tight">Strong disciples in healthy families</h2>
                    <p class="mt-4 text-slate/85">{{ $site['organization']['vision'] }}</p>
                    <p class="mt-5 rounded-2xl bg-mist p-4 font-heading text-xl text-pine">"{{ $site['organization']['vision_statement'] }}"</p>
                </article>
            </div>
        </div>
    </section>

    <section class="bg-white/70 py-16 md:py-20">
        <div class="container-base">
            <div class="mb-10 max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">Core Values</p>
                <h2 class="mt-3 text-3xl leading-tight md:text-4xl">Convictions that guide our work</h2>
            </div>
            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach ($site['organization']['values'] as $value)
                    <article class="glass-panel p-6 md:p-8">
                        <h3 class="text-2xl">{{ $value['title'] }}</h3>
                        <p class="mt-3 text-slate/80">{{ $value['description'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="mb-10 max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">Main Objectives</p>
                <h2 class="mt-3 text-3xl leading-tight md:text-4xl">What we are building toward</h2>
                <p class="mt-4 text-base text-slate/80 md:text-lg">
                    Our work is directed toward family discipleship that touches communities and nations.
                </p>
            </div>
            <div class="grid gap-6 md:grid-cols-3">
                @foreach ($site['organization']['objectives'] as $objective)
                    <article class="glass-panel p-6 md:p-8">
                        <h3 class="text-2xl">{{ $objective['title'] }}</h3>
                        <p class="mt-3 text-slate/80">{{ $objective['description'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    @include('partials.cta-banner', [
        'bannerTitle' => 'Everyone can take part in this noble work.',
        'bannerDescription' => 'Use your resources, influence, prayer, and service to help build strong families through family-based discipleship.',
        'primaryAction' => ['label' => 'Volunteer', 'to' => '/get-involved'],
        'secondaryAction' => ['label' => 'Donate', 'to' => '/donate'],
    ])
@endsection
