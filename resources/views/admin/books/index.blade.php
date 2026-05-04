@extends('layouts.admin', ['title' => 'Book Products'])

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-4xl">Book Products</h1>
            <p class="mt-2 text-slate/75">Manage books and PDF products shown in the shop.</p>
        </div>
        <a href="{{ route('admin.books.create') }}" class="rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">Add Book</a>
    </div>

    <section class="mt-7 overflow-hidden rounded-lg border border-sand bg-white">
        <div class="divide-y divide-sand">
            @forelse ($books as $book)
                <div class="grid gap-4 p-5 lg:grid-cols-[7rem_1fr_auto] lg:items-center">
                    <img src="{{ $book['cover_image'] }}" alt="{{ $book['title'] }}" class="aspect-[3/4] w-full object-cover lg:w-28">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-2xl">{{ $book['title'] }}</h2>
                            <span class="rounded-full bg-mist px-3 py-1 text-xs font-bold uppercase tracking-[0.12em] text-pine">{{ strtoupper($book['format'] ?? 'pdf') }}</span>
                            <span class="rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.12em] {{ ($book['is_available'] ?? true) ? 'bg-mist text-pine' : 'bg-sand text-slate' }}">
                                {{ ($book['is_available'] ?? true) ? 'Available' : 'Hidden' }}
                            </span>
                        </div>
                        <p class="mt-2 text-sm text-slate/75">{{ $book['currency'] ?? 'USD' }} {{ number_format((float) ($book['price'] ?? 0), 2) }} • {{ $book['category'] ?? 'Book' }}</p>
                        <p class="mt-2 text-sm text-slate/75">{{ $book['description'] }}</p>
                    </div>
                    <div class="flex flex-wrap gap-2 lg:justify-end">
                        <a href="{{ route('shop.book', $book['slug']) }}" class="rounded-full border border-sand px-4 py-2 text-sm font-bold text-slate hover:bg-mist">Preview</a>
                        <a href="{{ route('admin.books.edit', $book['slug']) }}" class="rounded-full bg-pine px-4 py-2 text-sm font-bold text-white hover:bg-sage">Edit</a>
                        <form method="POST" action="{{ route('admin.books.destroy', $book['slug']) }}" onsubmit="return confirm('Delete this book?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-full border border-red-200 px-4 py-2 text-sm font-bold text-red-700 hover:bg-red-50">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-slate/70">No book products yet.</div>
            @endforelse
        </div>
    </section>
@endsection
