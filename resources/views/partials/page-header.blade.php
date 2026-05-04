@php
    $primaryHref = isset($primaryAction) ? (str_starts_with($primaryAction['to'], '#') ? $primaryAction['to'] : url($primaryAction['to'])) : null;
    $secondaryHref = isset($secondaryAction) ? (str_starts_with($secondaryAction['to'], '#') ? $secondaryAction['to'] : url($secondaryAction['to'])) : null;
    $image = $headerImage ?? 'https://images.unsplash.com/photo-1529156069898-49953e39b3ac?auto=format&fit=crop&w=2000&q=80';
@endphp

<header class="relative overflow-hidden bg-pine py-20 text-white md:py-24">
    <img src="{{ $image }}" alt="" class="absolute inset-0 h-full w-full object-cover" loading="eager" fetchpriority="high" decoding="async" sizes="100vw">
    <div class="absolute inset-0 bg-gradient-to-r from-pine/95 via-pine/80 to-pine/35"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-black/20 via-transparent to-black/30"></div>
    <div class="container-base relative z-10">
        <p class="mb-3 text-sm font-semibold uppercase tracking-[0.18em] text-cream/80">{{ $eyebrow }}</p>
        <h1 class="max-w-3xl animate-rise text-4xl leading-tight text-white md:text-5xl">{{ $headerTitle }}</h1>
        <p class="mt-6 max-w-3xl text-base text-cream/90 md:text-lg">{{ $headerDescription }}</p>
        @if (isset($primaryAction) || isset($secondaryAction))
            <div class="mt-8 flex flex-wrap gap-3">
                @if (isset($primaryAction))
                    <a href="{{ $primaryHref }}" class="inline-flex items-center justify-center rounded-full bg-white px-5 py-3 text-sm font-semibold tracking-wide text-pine transition hover:bg-cream">
                        {{ $primaryAction['label'] }}
                    </a>
                @endif
                @if (isset($secondaryAction))
                    <a href="{{ $secondaryHref }}" class="inline-flex items-center justify-center rounded-full border border-white/50 bg-transparent px-5 py-3 text-sm font-semibold tracking-wide text-white transition hover:bg-white/10">
                        {{ $secondaryAction['label'] }}
                    </a>
                @endif
            </div>
        @endif
    </div>
</header>
