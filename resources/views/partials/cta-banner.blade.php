@php
    $primaryHref = isset($primaryAction) ? (str_starts_with($primaryAction['to'], '#') ? $primaryAction['to'] : url($primaryAction['to'])) : null;
    $secondaryHref = isset($secondaryAction) ? (str_starts_with($secondaryAction['to'], '#') ? $secondaryAction['to'] : url($secondaryAction['to'])) : null;
@endphp

<section class="container-base py-8 md:py-12">
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-r from-pine via-sage to-pine px-6 py-10 text-white shadow-soft md:px-12">
        <div class="pointer-events-none absolute -right-16 top-0 h-56 w-56 rounded-full bg-ember/25 blur-3xl"></div>
        <h2 class="relative text-3xl leading-tight text-white md:text-4xl">{{ $bannerTitle }}</h2>
        <p class="relative mt-4 max-w-2xl text-white/90">{{ $bannerDescription }}</p>
        <div class="relative mt-7 flex flex-wrap gap-3">
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
    </div>
</section>
