<div data-section class="rounded-lg border border-sand bg-cream/50 p-4">
    <div class="flex flex-wrap items-center justify-between gap-3">
        <label class="grid gap-2">
            <span class="text-sm font-bold text-pine">Section Type</span>
            <select name="sections[{{ $index }}][type]" class="field-input min-w-40">
                @foreach (['text' => 'Text', 'image' => 'Image', 'quote' => 'Quote', 'cta' => 'Call To Action'] as $value => $label)
                    <option value="{{ $value }}" @selected(($section['type'] ?? 'text') === $value)>{{ $label }}</option>
                @endforeach
            </select>
        </label>
        <button type="button" data-remove-section class="rounded-full border border-sand bg-white px-4 py-2 text-sm font-bold text-slate hover:bg-mist">Remove</button>
    </div>

    <div class="mt-4 grid gap-4 md:grid-cols-2">
        <label class="grid gap-2">
            <span class="text-sm font-bold text-pine">Title</span>
            <input name="sections[{{ $index }}][title]" value="{{ $section['title'] ?? '' }}" class="field-input">
        </label>
        <label class="grid gap-2">
            <span class="text-sm font-bold text-pine">Image URL or Path</span>
            <input name="sections[{{ $index }}][image_url]" value="{{ $section['image_url'] ?? '' }}" class="field-input">
            <input type="file" name="section_image_uploads[{{ $index }}]" accept="image/*" class="field-input bg-white">
        </label>
        <label class="grid gap-2 md:col-span-2">
            <span class="text-sm font-bold text-pine">Body</span>
            <textarea name="sections[{{ $index }}][body]" rows="5" class="field-input">{{ $section['body'] ?? '' }}</textarea>
        </label>
        <label class="grid gap-2">
            <span class="text-sm font-bold text-pine">Button Label</span>
            <input name="sections[{{ $index }}][button_label]" value="{{ $section['button_label'] ?? '' }}" class="field-input">
        </label>
        <label class="grid gap-2">
            <span class="text-sm font-bold text-pine">Button URL</span>
            <input name="sections[{{ $index }}][button_url]" value="{{ $section['button_url'] ?? '' }}" class="field-input">
        </label>
    </div>
</div>
