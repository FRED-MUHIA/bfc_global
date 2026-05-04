@extends('layouts.app', [
    'title' => 'Book Shop',
    'description' => 'Purchase Christian literature, discipleship books, and PDF resources.',
])

@section('content')
    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="mb-10 max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">Shop</p>
                <h1 class="mt-3 text-4xl leading-tight md:text-5xl">Books and PDF resources</h1>
                <p class="mt-4 text-base text-slate/80 md:text-lg">
                    Purchase discipleship books, workbooks, and downloadable PDF resources for homes, schools, churches, and families.
                </p>
            </div>

            <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                @foreach (($site['book_products'] ?? []) as $book)
                    @continue(!($book['is_available'] ?? true))
                    @php($bookSlug = $book['slug'] ?? str($book['title'])->slug())
                    <article class="overflow-hidden border border-sand bg-white shadow-soft transition hover:-translate-y-1">
                        <img src="{{ $book['cover_image'] }}" alt="{{ $book['title'] }}" class="h-64 w-full object-cover" loading="lazy" decoding="async" sizes="(min-width: 1024px) 33vw, (min-width: 768px) 50vw, 100vw">
                        <div class="p-6">
                            <p class="text-xs font-bold uppercase tracking-[0.13em] text-ember">{{ $book['category'] ?? 'Book' }}</p>
                            <h2 class="mt-3 text-2xl leading-tight">{{ $book['title'] }}</h2>
                            @if (!empty($book['author']))
                                <p class="mt-2 text-sm font-semibold text-slate/70">By {{ $book['author'] }}</p>
                            @endif
                            <p class="mt-4 text-sm leading-7 text-slate/80">{{ $book['description'] }}</p>
                            <div class="mt-5 flex flex-wrap items-center justify-between gap-3">
                                <p class="text-lg font-bold text-pine">{{ $book['currency'] ?? 'USD' }} {{ number_format((float) ($book['price'] ?? 0), 2) }}</p>
                                <span class="rounded-full bg-mist px-3 py-1 text-xs font-bold uppercase tracking-[0.1em] text-pine">{{ strtoupper($book['format'] ?? 'pdf') }}</span>
                            </div>
                            <a href="{{ route('shop.book', $bookSlug) }}" class="mt-6 inline-flex w-full items-center justify-center rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">
                                View Book
                            </a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
