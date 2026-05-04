@php
    $sermonUrl = $sermon['url'] ?? '#';
@endphp

<article class="rounded-lg border border-sand bg-white p-5 shadow-soft">
    <p class="text-xs font-bold uppercase tracking-[0.13em] text-ember">{{ $sermon['date'] ?? 'New' }}</p>
    <h3 class="mt-2 text-2xl leading-tight text-pine">{{ $sermon['title'] ?? 'Sermon' }}</h3>
    @if (!empty($sermon['speaker']))
        <p class="mt-2 text-sm font-semibold text-slate/70">{{ $sermon['speaker'] }}</p>
    @endif
    @if (!empty($sermon['description']))
        <p class="mt-3 text-sm leading-7 text-slate/80">{{ $sermon['description'] }}</p>
    @endif
    @if (!empty($sermon['url']))
        <a href="{{ $sermonUrl }}" target="_blank" rel="noopener" class="mt-5 inline-flex items-center justify-center rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">
            Open Sermon
        </a>
    @endif
</article>
