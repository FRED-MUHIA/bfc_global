@extends('layouts.app', [
    'title' => $book['title'],
    'description' => $book['description'],
])

@section('content')
    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="grid gap-10 lg:grid-cols-[0.85fr_1.15fr] lg:items-start">
                <img src="{{ $book['cover_image'] }}" alt="{{ $book['title'] }}" class="w-full border border-sand object-cover shadow-soft">

                <article class="glass-panel p-6 md:p-8">
                    <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">{{ $book['category'] ?? 'Book' }}</p>
                    <h1 class="mt-3 text-4xl leading-tight md:text-5xl">{{ $book['title'] }}</h1>
                    @if (!empty($book['author']))
                        <p class="mt-3 text-sm font-semibold text-slate/70">By {{ $book['author'] }}</p>
                    @endif
                    <p class="mt-6 text-base leading-8 text-slate/85">{{ $book['description'] }}</p>
                    <div class="mt-6 flex flex-wrap items-center gap-3">
                        <span class="rounded-full bg-mist px-4 py-2 text-sm font-bold text-pine">{{ strtoupper($book['format'] ?? 'pdf') }}</span>
                        <span class="rounded-full bg-ember px-4 py-2 text-sm font-bold text-white">{{ $book['currency'] ?? 'USD' }} {{ number_format((float) ($book['price'] ?? 0), 2) }}</span>
                    </div>
                    <div class="mt-8 flex flex-wrap gap-3">
                        @if (in_array($book['format'] ?? 'pdf', ['pdf', 'both'], true))
                            <a href="{{ $book['purchase_url'] ?: route('donate') }}" class="inline-flex items-center justify-center rounded-full bg-pine px-6 py-3 text-sm font-bold text-white hover:bg-sage">
                                Purchase PDF
                            </a>
                        @else
                            <a href="{{ $book['purchase_url'] ?: route('contact') }}" class="inline-flex items-center justify-center rounded-full bg-pine px-6 py-3 text-sm font-bold text-white hover:bg-sage">
                                Purchase Book
                            </a>
                        @endif
                        @if (!empty($book['pdf_url']))
                            <a href="{{ $book['pdf_url'] }}" class="inline-flex items-center justify-center rounded-full border border-sage/30 px-6 py-3 text-sm font-bold text-pine hover:bg-sage/10">
                                PDF File
                            </a>
                        @endif
                    </div>
                </article>
            </div>
        </div>
    </section>
@endsection
