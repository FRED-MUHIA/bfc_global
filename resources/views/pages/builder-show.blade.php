@extends('layouts.app')

@php
    $hero = $pageContent->hero ?: [];
    $sections = $pageContent->sections ?: [];
@endphp

@section('content')
    <section class="relative overflow-hidden bg-pine text-white">
        @if (!empty($hero['image_url']))
            <img src="{{ $hero['image_url'] }}" alt="" class="absolute inset-0 h-full w-full object-cover opacity-35" loading="eager" fetchpriority="high" decoding="async" sizes="100vw">
        @endif
        <div class="container-base relative py-20 sm:py-24 lg:py-28">
            @if (!empty($hero['eyebrow']))
                <p class="text-sm font-bold uppercase tracking-[0.18em] text-sand">{{ $hero['eyebrow'] }}</p>
            @endif
            <h1 class="mt-4 max-w-4xl text-4xl text-white sm:text-5xl lg:text-6xl">{{ $hero['title'] ?? $pageContent->title }}</h1>
            @if (!empty($hero['body']))
                <p class="mt-5 max-w-3xl text-lg text-white/85">{{ $hero['body'] }}</p>
            @endif
        </div>
    </section>

    <section class="container-base py-14">
        <div class="mx-auto grid max-w-5xl gap-8">
            @forelse ($sections as $section)
                @php($type = $section['type'] ?? 'text')

                @if ($type === 'image')
                    <article class="grid gap-6 md:grid-cols-2 md:items-center">
                        @if (!empty($section['image_url']))
                            <img src="{{ $section['image_url'] }}" alt="" class="aspect-[4/3] w-full rounded-lg object-cover" loading="lazy" decoding="async" sizes="(min-width: 768px) 50vw, 100vw">
                        @endif
                        <div>
                            @if (!empty($section['title']))
                                <h2 class="text-3xl">{{ $section['title'] }}</h2>
                            @endif
                            @if (!empty($section['body']))
                                <div class="mt-4 whitespace-pre-line text-slate/80">{{ $section['body'] }}</div>
                            @endif
                        </div>
                    </article>
                @elseif ($type === 'quote')
                    <blockquote class="border-l-4 border-ember bg-white px-6 py-5 text-xl font-semibold text-pine shadow-soft">
                        <div class="whitespace-pre-line">{{ $section['body'] ?? '' }}</div>
                        @if (!empty($section['title']))
                            <cite class="mt-4 block text-sm not-italic text-slate/70">{{ $section['title'] }}</cite>
                        @endif
                    </blockquote>
                @elseif ($type === 'cta')
                    <article class="rounded-lg bg-pine px-6 py-8 text-white sm:px-8">
                        @if (!empty($section['title']))
                            <h2 class="text-3xl text-white">{{ $section['title'] }}</h2>
                        @endif
                        @if (!empty($section['body']))
                            <div class="mt-3 max-w-3xl whitespace-pre-line text-white/85">{{ $section['body'] }}</div>
                        @endif
                        @if (!empty($section['button_label']) && !empty($section['button_url']))
                            <a href="{{ url($section['button_url']) }}" class="mt-6 inline-flex rounded-full bg-ember px-5 py-3 text-sm font-bold text-white hover:bg-ember/90">
                                {{ $section['button_label'] }}
                            </a>
                        @endif
                    </article>
                @else
                    <article class="bg-white/70">
                        @if (!empty($section['title']))
                            <h2 class="text-3xl">{{ $section['title'] }}</h2>
                        @endif
                        @if (!empty($section['body']))
                            <div class="mt-4 whitespace-pre-line text-slate/80">{{ $section['body'] }}</div>
                        @endif
                        @if (!empty($section['button_label']) && !empty($section['button_url']))
                            <a href="{{ url($section['button_url']) }}" class="mt-5 inline-flex rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">
                                {{ $section['button_label'] }}
                            </a>
                        @endif
                    </article>
                @endif
            @empty
                <div class="rounded-lg border border-sand bg-white p-6 text-slate/75">
                    This page has been published, but no content sections have been added yet.
                </div>
            @endforelse
        </div>
    </section>
@endsection
