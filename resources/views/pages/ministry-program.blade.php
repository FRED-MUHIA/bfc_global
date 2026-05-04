@extends('layouts.app', [
    'title' => $program['title'],
    'description' => $program['description'],
])

@php
    $programImage = $program['image'] ?? 'https://images.unsplash.com/photo-1523050854058-8df90110c9f1?auto=format&fit=crop&w=1200&q=80';
    $registration = $program['registration'] ?? [];
    $registrationOpen = $registration['open'] ?? true;
    $registerLabel = $registration['button_label'] ?? 'Register';
@endphp

@section('content')
    @include('partials.page-header', [
        'eyebrow' => 'Ministry Program',
        'headerTitle' => $program['title'],
        'headerDescription' => $program['description'],
        'primaryAction' => ['label' => $registerLabel, 'to' => route('program.register', $program['slug'])],
        'secondaryAction' => ['label' => 'Support Ministry', 'to' => '/donate'],
    ])

    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="grid gap-8 lg:grid-cols-[0.85fr_1.15fr]">
                <aside class="rounded-3xl bg-ember p-6 text-white shadow-soft md:p-8">
                    <p class="text-xs font-bold uppercase tracking-[0.15em] text-white/80">Program Details</p>
                    <div class="mt-6 space-y-5">
                        <div>
                            <p class="text-sm font-bold uppercase tracking-[0.12em] text-white/70">Audience</p>
                            <p class="mt-2 text-xl font-semibold">{{ $program['audience'] }}</p>
                        </div>
                        <div class="border-t border-white/25 pt-5">
                            <p class="text-sm font-bold uppercase tracking-[0.12em] text-white/70">Format</p>
                            <p class="mt-2 text-lg leading-7">{{ $program['format'] }}</p>
                        </div>
                        @if (! empty($program['subtitle']))
                            <div class="border-t border-white/25 pt-5">
                                <p class="text-sm font-bold uppercase tracking-[0.12em] text-white/70">Focus</p>
                                <p class="mt-2 text-lg leading-7">{{ $program['subtitle'] }}</p>
                            </div>
                        @endif
                    </div>
                    <img
                        src="{{ $programImage }}"
                        alt="{{ $program['title'] }}"
                        class="mt-8 aspect-[4/3] w-full rounded-2xl object-cover shadow-soft"
                        loading="lazy"
                        decoding="async"
                        sizes="(min-width: 1024px) 35vw, 100vw"
                    >
                </aside>

                <article class="glass-panel p-6 md:p-10">
                    <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">Overview</p>
                    <h2 class="mt-3 text-3xl leading-tight md:text-4xl">{{ $program['title'] }}</h2>
                    <p class="mt-6 text-base leading-8 text-slate/85 md:text-lg">
                        {{ $program['description'] }}
                    </p>

                    <div class="mt-8 grid gap-5 md:grid-cols-2">
                        <div class="rounded-2xl bg-mist p-5">
                            <h3 class="text-xl text-pine">How to Take Part</h3>
                            <p class="mt-3 text-sm leading-7 text-slate/80">
                                {{ $registrationOpen ? ($registration['intro'] ?? 'Choose an intake and complete the registration form. Our team will follow up with the next steps.') : 'Registration for this program is currently closed. Check back for the next intake.' }}
                            </p>
                        </div>
                        <div class="rounded-2xl bg-pine p-5 text-white">
                            <h3 class="text-xl text-white">Support This Work</h3>
                            <p class="mt-3 text-sm leading-7 text-white/82">
                                You can give toward discipleship training, learning materials, events, and ministry facilitation.
                            </p>
                        </div>
                    </div>

                    <div class="mt-8 flex flex-wrap gap-3">
                        <a href="{{ route('program.register', $program['slug']) }}" class="inline-flex items-center justify-center rounded-full bg-pine px-6 py-3 text-base font-semibold tracking-wide text-white transition hover:bg-sage">
                            {{ $registrationOpen ? $registerLabel : 'Registration Closed' }}
                        </a>
                        <a href="{{ route('donate') }}" class="inline-flex items-center justify-center rounded-full bg-ember px-6 py-3 text-base font-semibold tracking-wide text-white transition hover:bg-ember/90">
                            Donate
                        </a>
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
