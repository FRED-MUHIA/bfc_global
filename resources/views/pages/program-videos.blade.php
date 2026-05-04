@extends('layouts.app', [
    'title' => 'Program Videos',
    'description' => 'Watch program videos, teachings, ministry highlights, and discipleship conversations.',
])

@section('content')
    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="mb-10 max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">Program Videos</p>
                <h1 class="mt-3 text-4xl leading-tight md:text-5xl">Teachings, highlights, and discipleship conversations</h1>
                <p class="mt-4 text-base text-slate/80 md:text-lg">
                    Watch recorded ministry updates, practical teachings, and training moments from BUILD programs.
                </p>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                @foreach (($site['program_videos'] ?? []) as $video)
                    <article class="overflow-hidden rounded-3xl border border-sand bg-white shadow-soft">
                        <div class="aspect-video bg-slate/10">
                            @if (!empty($video['video_url']))
                                <iframe
                                    src="{{ $video['video_url'] }}"
                                    title="{{ $video['title'] }}"
                                    class="h-full w-full"
                                    loading="lazy"
                                    allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                    allowfullscreen
                                ></iframe>
                            @else
                                <img src="{{ $video['thumbnail'] ?? '' }}" alt="{{ $video['title'] }}" class="h-full w-full object-cover" loading="lazy" decoding="async" sizes="(min-width: 1024px) 33vw, 100vw">
                            @endif
                        </div>
                        <div class="p-6">
                            <p class="text-xs font-bold uppercase tracking-[0.13em] text-ember">{{ $video['category'] ?? 'Video' }}</p>
                            <h2 class="mt-3 text-2xl leading-tight">{{ $video['title'] }}</h2>
                            <p class="mt-3 text-sm leading-7 text-slate/80">{{ $video['description'] ?? '' }}</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
