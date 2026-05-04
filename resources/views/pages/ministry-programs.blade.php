@extends('layouts.app', [
    'title' => 'Ministry Programs',
    'description' => 'Explore BUILD discipleship initiatives, training programs, family worship, parental discipleship, and resource hub ministries.',
])

@section('content')
    @include('partials.page-header', [
        'eyebrow' => 'Ministry Programs',
        'headerTitle' => 'BUILD discipleship programs for students, families, leaders, and the church',
        'headerDescription' => 'Our ministry programs restore discipleship into the context of family, learning institutions, young professionals, marriage, and the local church.',
        'primaryAction' => ['label' => 'Join a Program', 'to' => '/contact'],
        'secondaryAction' => ['label' => 'Support Ministry', 'to' => '/donate'],
    ])

    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="mb-10 max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">BUILD Ministry Pathways</p>
                <h2 class="mt-3 text-3xl leading-tight md:text-4xl">Discipleship initiatives with practical reach</h2>
                <p class="mt-4 text-base text-slate/80 md:text-lg">
                    These programs engage campuses, high schools, homes, families, men, women, young professionals, and ministry trainees with biblical discipleship.
                </p>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                @foreach (($site['ministry_programs'] ?? []) as $program)
                    @php
                        $cardStyles = [
                            ['card' => 'bg-pine text-white border-pine', 'title' => 'text-white', 'muted' => 'text-white/75', 'body' => 'text-white/88', 'pill' => 'bg-white/15 text-white'],
                            ['card' => 'bg-ember text-white border-ember', 'title' => 'text-white', 'muted' => 'text-white/80', 'body' => 'text-white/90', 'pill' => 'bg-white/18 text-white'],
                            ['card' => 'bg-white text-slate border-sand', 'title' => 'text-pine', 'muted' => 'text-sage', 'body' => 'text-slate/80', 'pill' => 'bg-mist text-pine'],
                            ['card' => 'bg-sage text-white border-sage', 'title' => 'text-white', 'muted' => 'text-white/75', 'body' => 'text-white/88', 'pill' => 'bg-white/15 text-white'],
                        ];
                        $style = $cardStyles[$loop->index % count($cardStyles)];
                    @endphp
                    <article class="rounded-3xl border p-6 shadow-soft transition hover:-translate-y-1 md:p-8 {{ $style['card'] }}">
                        <p class="text-xs font-bold uppercase tracking-[0.13em] {{ $style['muted'] }}">Program {{ $loop->iteration }}</p>
                        <h3 class="mt-3 text-2xl leading-tight {{ $style['title'] }}">{{ $program['title'] }}</h3>
                        @if (! empty($program['subtitle']))
                            <p class="mt-2 text-sm font-bold uppercase tracking-[0.12em] {{ $style['muted'] }}">{{ $program['subtitle'] }}</p>
                        @endif
                        <div class="mt-4 flex flex-wrap gap-2">
                            <span class="rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.09em] {{ $style['pill'] }}">{{ $program['audience'] }}</span>
                        </div>
                        <p class="mt-4 text-sm font-semibold {{ $style['muted'] }}">{{ $program['format'] }}</p>
                        <p class="mt-4 text-sm leading-7 {{ $style['body'] }}">{{ $program['description'] }}</p>
                        <a
                            href="{{ route('ministry-programs.show', $program['slug']) }}"
                            class="mt-6 inline-flex items-center justify-center rounded-full px-5 py-2 text-sm font-bold transition {{ str_contains($style['card'], 'bg-white') ? 'bg-ember text-white hover:bg-ember/90' : 'bg-white/90 text-pine hover:bg-white' }}"
                        >
                            Learn More
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white/70 py-16 md:py-20">
        <div class="container-base">
            <div class="grid gap-8 lg:grid-cols-[0.9fr_1.1fr]">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">Partner With BUILD</p>
                    <h2 class="mt-3 text-3xl leading-tight md:text-4xl">Help extend discipleship into schools, homes, campuses, and nations</h2>
                </div>
                <div class="glass-panel p-6 md:p-8">
                    <p class="text-base leading-8 text-slate/85 md:text-lg">
                        We welcome churches, Christian Unions, learning institutions, families, and ministry partners who desire to host, sponsor, or participate in BUILD discipleship programs.
                    </p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-full bg-pine px-6 py-3 text-base font-semibold tracking-wide text-white transition hover:bg-sage">
                            Contact Our Team
                        </a>
                        <a href="{{ route('donate') }}" class="inline-flex items-center justify-center rounded-full bg-ember px-6 py-3 text-base font-semibold tracking-wide text-white transition hover:bg-ember/90">
                            Give to Ministry
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
