@extends('layouts.app', [
    'title' => 'Resources Hub',
    'description' => 'Explore Christian literature, program videos, sermons, and family board games from Building Families and Community Global Trust.',
])

@section('content')
    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="mb-10 max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">Resource Areas</p>
                <h2 class="mt-3 text-3xl leading-tight md:text-4xl">Equipping families and communities with practical tools</h2>
                <p class="mt-4 text-base text-slate/80 md:text-lg">
                    The hub brings together materials and media for discipleship, teaching, encouragement, family fellowship, and ministry growth.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2">
                @foreach (($site['resources_hub'] ?? []) as $resource)
                    @php
                        $colors = [
                            'bg-pine text-white',
                            'bg-ember text-white',
                            'bg-white text-slate',
                            'bg-sage text-white',
                        ];
                        $cardColor = $colors[$loop->index % count($colors)];
                        $isLight = str_contains($cardColor, 'bg-white');
                    @endphp
                    <article class="overflow-hidden rounded-3xl border border-sand shadow-soft transition hover:-translate-y-1 {{ $cardColor }}">
                        <div class="grid min-h-full md:grid-cols-[0.9fr_1.1fr]">
                            <img src="{{ $resource['image'] }}" alt="{{ $resource['title'] }}" class="h-64 w-full object-cover md:h-full" loading="lazy">
                            <div class="p-6 md:p-8">
                                <p class="text-xs font-bold uppercase tracking-[0.14em] {{ $isLight ? 'text-ember' : 'text-white/75' }}">Resources</p>
                                <h3 class="mt-3 text-2xl leading-tight {{ $isLight ? 'text-pine' : 'text-white' }}">{{ $resource['title'] }}</h3>
                                <p class="mt-4 text-base leading-8 {{ $isLight ? 'text-slate/80' : 'text-white/85' }}">
                                    {{ $resource['description'] }}
                                </p>
                                <a
                                    href="{{ $resource['button_url'] ?? $resource['shop_url'] ?? route('contact') }}"
                                    class="mt-6 inline-flex items-center justify-center rounded-full px-5 py-3 text-sm font-semibold tracking-wide transition {{ $isLight ? 'bg-ember text-white hover:bg-ember/90' : 'bg-white/90 text-pine hover:bg-white' }}"
                                >
                                    {{ $resource['button_label'] ?? 'Request Access' }}
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
