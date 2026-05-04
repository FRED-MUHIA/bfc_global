<section class="relative w-full" data-hero-slider data-auto-ms="7000">
    <div class="relative min-h-[24rem] w-full overflow-hidden md:min-h-[29rem]">
            @foreach ($slides as $index => $slide)
                <article
                    data-slide
                    aria-hidden="{{ $index !== 0 ? 'true' : 'false' }}"
                    class="absolute inset-0 transition-opacity duration-700 {{ $index === 0 ? 'pointer-events-auto opacity-100' : 'pointer-events-none opacity-0' }}"
                >
                    <img src="{{ $slide['image'] }}" alt="{{ $slide['title'] }}" class="h-full w-full object-cover" loading="{{ $index === 0 ? 'eager' : 'lazy' }}">
                    <div class="absolute inset-0 bg-gradient-to-r from-pine/90 via-pine/50 to-transparent"></div>
                    <div class="absolute inset-0 flex items-center">
                        <div class="w-full px-5 py-8 md:max-w-2xl md:px-10 lg:px-16 xl:px-24">
                            <p class="text-sm font-bold uppercase tracking-[0.16em] text-ember">{{ $slide['eyebrow'] }}</p>
                            <h1 class="mt-3 text-4xl leading-tight text-white md:text-5xl">{{ $slide['title'] }}</h1>
                            <p class="mt-4 text-base text-white/85 md:text-lg">{{ $slide['description'] }}</p>
                            <div class="mt-7 flex flex-wrap gap-3">
                                <a href="{{ url($slide['primary_cta']['to']) }}" class="inline-flex items-center justify-center rounded-full bg-ember px-6 py-3 text-base font-semibold tracking-wide text-white transition hover:bg-ember/90">
                                    {{ $slide['primary_cta']['label'] }}
                                </a>
                                <a href="{{ url($slide['secondary_cta']['to']) }}" class="inline-flex items-center justify-center rounded-full border border-white/55 bg-white/10 px-6 py-3 text-base font-semibold tracking-wide text-white transition hover:bg-white/20">
                                    {{ $slide['secondary_cta']['label'] }}
                                </a>
                            </div>
                        </div>
                    </div>
                </article>
            @endforeach

            <button type="button" data-slider-prev aria-label="Previous slide" class="absolute left-3 top-1/2 z-20 inline-flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/70 bg-white/80 text-2xl text-pine shadow transition hover:bg-white">
                ‹
            </button>
            <button type="button" data-slider-next aria-label="Next slide" class="absolute right-3 top-1/2 z-20 inline-flex h-11 w-11 -translate-y-1/2 items-center justify-center rounded-full border border-white/70 bg-white/80 text-2xl text-pine shadow transition hover:bg-white">
                ›
            </button>

            <div class="absolute bottom-5 left-1/2 z-20 flex -translate-x-1/2 gap-2">
                @foreach ($slides as $index => $slide)
                    <button
                        type="button"
                        data-slider-dot
                        data-index="{{ $index }}"
                        aria-label="Go to slide {{ $index + 1 }}"
                        class="h-2.5 rounded-full transition {{ $index === 0 ? 'w-8 bg-ember' : 'w-2.5 bg-white/85 hover:bg-white' }}"
                    ></button>
                @endforeach
            </div>
    </div>
</section>
