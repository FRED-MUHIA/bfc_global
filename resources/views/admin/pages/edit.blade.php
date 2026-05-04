@extends('layouts.admin', ['title' => 'Edit ' . $definition['label']])

@section('content')
    <div class="flex flex-wrap items-start justify-between gap-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-pine hover:text-sage">Back to dashboard</a>
            <h1 class="mt-2 text-4xl">Edit {{ $definition['label'] }}</h1>
            <p class="mt-2 text-slate/75">Public URL: <a href="{{ url($definition['path']) }}" class="font-bold text-pine hover:text-sage">{{ $definition['path'] }}</a></p>
        </div>
    </div>

    @if ($errors->any())
        <div class="mt-6 rounded-lg border border-red-200 bg-red-50 px-4 py-3 text-sm text-red-800">
            Please fix the highlighted fields and save again.
        </div>
    @endif

    <form method="POST" action="{{ route('admin.pages.update', $definition['slug']) }}" enctype="multipart/form-data" class="mt-7 grid gap-6">
        @csrf
        @method('PUT')

        <section class="rounded-lg border border-sand bg-white p-5">
            <div class="flex flex-wrap items-center justify-between gap-3">
                <h2 class="text-2xl">Frontend Content for This Page</h2>
                <span class="rounded-full bg-mist px-3 py-1 text-xs font-bold uppercase tracking-[0.12em] text-pine">Wired</span>
            </div>
            <p class="mt-2 max-w-3xl text-sm text-slate/70">
                Edit the existing frontend data for this page here, including text, cards, image URLs, gallery items, program details, and list content. These values feed the live Blade page directly.
            </p>
            <div class="mt-5 grid gap-5">
                @foreach (old('page_source', $pageSource) as $sourceKey => $sourceValue)
                    @include('admin.pages.partials.source-fields', [
                        'label' => str($sourceKey)->replace(['_', '.'], ' ')->title(),
                        'name' => "page_source[$sourceKey]",
                        'value' => $sourceValue,
                        'depth' => 0,
                    ])
                @endforeach
            </div>
        </section>

        <div class="sticky bottom-0 z-20 -mx-4 border-t border-sand bg-cream/95 px-4 py-4 backdrop-blur sm:mx-0 sm:rounded-lg sm:border">
            <div class="flex flex-wrap justify-end gap-3">
                <a href="{{ route('admin.dashboard') }}" class="rounded-full border border-sand bg-white px-5 py-3 text-sm font-bold text-slate hover:bg-mist">Cancel</a>
                <button type="submit" class="rounded-full bg-pine px-6 py-3 text-sm font-bold text-white hover:bg-sage">Save Page</button>
            </div>
        </div>
    </form>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.addEventListener('click', (event) => {
                const addButton = event.target.closest('[data-source-add]');
                const removeButton = event.target.closest('[data-source-remove]');

                if (addButton) {
                    const list = addButton.closest('[data-source-list]');
                    const items = list.querySelector('[data-source-list-items]');
                    const templateItem = items.querySelector('[data-source-list-item]');

                    if (!templateItem) {
                        return;
                    }

                    const newIndex = items.querySelectorAll('[data-source-list-item]').length;
                    const clone = templateItem.cloneNode(true);

                    clone.querySelectorAll('input, textarea, select').forEach((field) => {
                        field.name = field.name.replace(/\[\d+\]/, `[${newIndex}]`);
                        if (field.type === 'file') {
                            field.value = '';
                        } else {
                            field.value = '';
                        }
                    });
                    clone.querySelectorAll('img').forEach((image) => image.remove());
                    clone.querySelectorAll('[data-source-list-item]').forEach((nestedItem, index) => {
                        if (index > 0) {
                            nestedItem.remove();
                        }
                    });

                    const title = clone.querySelector('p');
                    if (title) {
                        title.textContent = title.textContent.replace(/\d+$/, String(newIndex + 1));
                    }

                    items.appendChild(clone);
                }

                if (removeButton) {
                    const items = removeButton.closest('[data-source-list-items]');
                    if (items && items.querySelectorAll('[data-source-list-item]').length > 1) {
                        removeButton.closest('[data-source-list-item]').remove();
                    }
                }
            });
        });
    </script>
@endsection
