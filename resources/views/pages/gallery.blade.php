@extends('layouts.app', [
    'title' => 'Gallery',
    'description' => 'View ministry photos from BFC Global Trust discipleship programs, family workshops, youth gatherings, worship, outreach, and training moments.',
])

@section('content')
    @php
        $galleryPhotos = $site['gallery_photos'] ?? [];
        $galleryCategories = collect($galleryPhotos)->pluck('category')->filter()->unique()->values();
    @endphp

    <section class="py-16 md:py-20">
        <div class="container-base">
            <div class="mb-10 max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">Ministry Moments</p>
                <h2 class="mt-3 text-3xl leading-tight md:text-4xl">Photos from discipleship, training, and community life</h2>
                <p class="mt-4 text-base text-slate/80 md:text-lg">
                    These photos represent the heart of our ministry: building families, touching communities, and equipping disciples for global influence.
                </p>
            </div>

            <div class="mb-8 flex flex-wrap gap-2" data-gallery-filters>
                <button type="button" data-gallery-filter="all" class="rounded-full bg-pine px-4 py-2 text-sm font-bold text-white">All</button>
                @foreach ($galleryCategories as $category)
                    <button type="button" data-gallery-filter="{{ $category }}" class="rounded-full border border-sand bg-white px-4 py-2 text-sm font-bold text-pine hover:bg-mist">
                        {{ $category }}
                    </button>
                @endforeach
            </div>

            <div class="grid gap-5 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($galleryPhotos as $photo)
                    <button
                        type="button"
                        data-gallery-item
                        data-gallery-category="{{ $photo['category'] }}"
                        data-gallery-image="{{ $photo['image'] }}"
                        data-gallery-title="{{ $photo['title'] }}"
                        class="group overflow-hidden border border-sand bg-white shadow-soft transition hover:-translate-y-1 focus:outline-none focus:ring-2 focus:ring-sage/40"
                    >
                        <img src="{{ $photo['image'] }}" alt="{{ $photo['title'] }}" class="aspect-[4/3] h-full w-full object-cover transition duration-500 group-hover:scale-105" loading="lazy">
                    </button>
                @endforeach
            </div>
        </div>
    </section>

    <div data-gallery-modal class="fixed inset-0 z-[80] hidden items-center justify-center bg-slate/80 p-4" role="dialog" aria-modal="true">
        <div class="relative w-full max-w-5xl">
            <button type="button" data-gallery-close class="absolute right-3 top-3 z-10 inline-flex h-11 w-11 items-center justify-center rounded-full bg-white text-2xl text-pine shadow-soft" aria-label="Close image">&times;</button>
            <img data-gallery-modal-image src="" alt="" class="max-h-[84vh] w-full rounded-2xl object-contain bg-white">
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const items = Array.from(document.querySelectorAll('[data-gallery-item]'));
            const filterButtons = Array.from(document.querySelectorAll('[data-gallery-filter]'));
            const modal = document.querySelector('[data-gallery-modal]');
            const modalImage = document.querySelector('[data-gallery-modal-image]');
            const closeButton = document.querySelector('[data-gallery-close]');

            filterButtons.forEach((button) => {
                button.addEventListener('click', () => {
                    const category = button.dataset.galleryFilter;

                    filterButtons.forEach((filterButton) => {
                        filterButton.className = 'rounded-full border border-sand bg-white px-4 py-2 text-sm font-bold text-pine hover:bg-mist';
                    });
                    button.className = 'rounded-full bg-pine px-4 py-2 text-sm font-bold text-white';

                    items.forEach((item) => {
                        item.classList.toggle('hidden', category !== 'all' && item.dataset.galleryCategory !== category);
                    });
                });
            });

            items.forEach((item) => {
                item.addEventListener('click', () => {
                    modalImage.src = item.dataset.galleryImage;
                    modalImage.alt = item.dataset.galleryTitle || '';
                    modal.classList.remove('hidden');
                    modal.classList.add('flex');
                });
            });

            const closeModal = () => {
                modal.classList.add('hidden');
                modal.classList.remove('flex');
                modalImage.src = '';
            };

            closeButton?.addEventListener('click', closeModal);
            modal?.addEventListener('click', (event) => {
                if (event.target === modal) {
                    closeModal();
                }
            });
            document.addEventListener('keydown', (event) => {
                if (event.key === 'Escape' && modal?.classList.contains('flex')) {
                    closeModal();
                }
            });
        });
    </script>
@endsection
