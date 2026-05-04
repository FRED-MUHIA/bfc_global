@php
    $depth = $depth ?? 0;
    $isList = is_array($value) && array_is_list($value);
    $isAssoc = is_array($value) && ! $isList;
    $fieldLabel = str((string) $label)->replace(['_', '-'], ' ')->title();
@endphp

@if ($isList)
    <fieldset data-source-list class="{{ $depth === 0 ? 'rounded-lg border border-sand bg-cream/40 p-4' : 'mt-3 rounded-lg border border-sand/80 bg-white/70 p-4' }}">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <legend class="px-2 text-sm font-bold uppercase tracking-[0.12em] text-ember">{{ $fieldLabel }}</legend>
            <button type="button" data-source-add class="rounded-full bg-ember px-4 py-2 text-xs font-bold text-white hover:bg-ember/90">Add {{ str($fieldLabel)->singular() }}</button>
        </div>
        <div class="mt-3 grid gap-4" data-source-list-items>
            @foreach ($value as $index => $item)
                <div class="rounded-lg border border-sand bg-white p-4" data-source-list-item>
                    <div class="mb-3 flex flex-wrap items-center justify-between gap-3">
                        <p class="text-sm font-bold text-pine">{{ $fieldLabel }} {{ $index + 1 }}</p>
                        <button type="button" data-source-remove class="rounded-full border border-sand px-3 py-1 text-xs font-bold text-pine hover:bg-mist">Remove</button>
                    </div>
                    @include('admin.pages.partials.source-fields', [
                        'label' => $fieldLabel . ' ' . ($index + 1),
                        'name' => $name . "[$index]",
                        'value' => $item,
                        'depth' => $depth + 1,
                    ])
                </div>
            @endforeach
        </div>
    </fieldset>
@elseif ($isAssoc)
    <fieldset class="{{ $depth === 0 ? 'rounded-lg border border-sand bg-cream/40 p-4' : 'grid gap-4' }}">
        @if ($depth === 0)
            <legend class="px-2 text-sm font-bold uppercase tracking-[0.12em] text-ember">{{ $fieldLabel }}</legend>
        @endif
        <div class="{{ $depth === 0 ? 'mt-3 grid gap-4 md:grid-cols-2' : 'grid gap-4 md:grid-cols-2' }}">
            @foreach ($value as $childKey => $childValue)
                <div class="{{ is_array($childValue) ? 'md:col-span-2' : '' }}">
                    @include('admin.pages.partials.source-fields', [
                        'label' => $childKey,
                        'name' => $name . "[$childKey]",
                        'value' => $childValue,
                        'depth' => $depth + 1,
                    ])
                </div>
            @endforeach
        </div>
    </fieldset>
@else
    @php
        $stringValue = (string) $value;
        $lowerLabel = str((string) $label)->lower();
        $useTextarea = strlen($stringValue) > 120 || $lowerLabel->contains(['description', 'paragraph', 'content', 'quote', 'detail', 'overview', 'body', 'mission', 'vision']);
        $isImageField = $lowerLabel->contains(['image', 'photo', 'picture', 'thumbnail']);
        $uploadName = preg_replace('/^page_source/', 'page_source_uploads', $name, 1);
    @endphp
    <label class="grid gap-2">
        <span class="text-sm font-bold text-pine">{{ $fieldLabel }}</span>
        @if ($useTextarea)
            <textarea name="{{ $name }}" rows="4" class="field-input">{{ $stringValue }}</textarea>
        @else
            <input name="{{ $name }}" value="{{ $stringValue }}" class="field-input">
        @endif
        @if ($isImageField)
            <input type="file" name="{{ $uploadName }}" accept="image/*" class="field-input bg-white">
            @if ($stringValue !== '')
                <img src="{{ $stringValue }}" alt="" class="h-24 w-36 rounded-lg object-cover">
            @endif
        @endif
    </label>
@endif
