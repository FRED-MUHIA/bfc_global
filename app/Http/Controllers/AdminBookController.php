<?php

namespace App\Http\Controllers;

use App\Models\SiteSetting;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminBookController extends Controller
{
    public function index(): View
    {
        return view('admin.books.index', [
            'books' => collect($this->editableSite()['book_products'] ?? [])
                ->map(fn (array $book): array => [
                    ...$book,
                    'slug' => $book['slug'] ?? Str::slug($book['title']),
                ]),
        ]);
    }

    public function create(): View
    {
        return view('admin.books.form', [
            'mode' => 'create',
            'book' => $this->blankBook(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $book = $this->validatedBook($request);
        $site = $this->editableSite();
        $books = $site['book_products'] ?? [];

        if (collect($books)->contains(fn (array $existing): bool => ($existing['slug'] ?? '') === $book['slug'])) {
            return back()->withErrors(['slug' => 'A book with this slug already exists.'])->withInput();
        }

        $books[] = $book;
        $site['book_products'] = array_values($books);
        $this->saveSite($site);

        return redirect()->route('admin.books.index')->with('status', 'Book product created.');
    }

    public function edit(string $book): View
    {
        return view('admin.books.form', [
            'mode' => 'edit',
            'book' => $this->findBook($book),
        ]);
    }

    public function update(Request $request, string $book): RedirectResponse
    {
        $updatedBook = $this->validatedBook($request, $book);
        $site = $this->editableSite();
        $site['book_products'] = collect($site['book_products'] ?? [])
            ->map(fn (array $existing): array => ($existing['slug'] ?? Str::slug($existing['title'])) === $book ? $updatedBook : $existing)
            ->values()
            ->all();
        $this->saveSite($site);

        return redirect()->route('admin.books.index')->with('status', 'Book product updated.');
    }

    public function destroy(string $book): RedirectResponse
    {
        $site = $this->editableSite();
        $site['book_products'] = collect($site['book_products'] ?? [])
            ->reject(fn (array $existing): bool => ($existing['slug'] ?? Str::slug($existing['title'])) === $book)
            ->values()
            ->all();
        $this->saveSite($site);

        return redirect()->route('admin.books.index')->with('status', 'Book product deleted.');
    }

    private function validatedBook(Request $request, ?string $currentSlug = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180'],
            'author' => ['nullable', 'string', 'max:150'],
            'category' => ['nullable', 'string', 'max:120'],
            'description' => ['required', 'string', 'max:1200'],
            'price' => ['nullable', 'numeric', 'min:0', 'max:999999'],
            'currency' => ['required', 'string', 'size:3'],
            'cover_image' => ['nullable', 'string', 'max:800'],
            'cover_upload' => ['nullable', 'image', 'max:20480'],
            'format' => ['required', 'string', 'in:pdf,print,both'],
            'pdf_url' => ['nullable', 'string', 'max:800'],
            'purchase_url' => ['nullable', 'string', 'max:800'],
            'is_available' => ['nullable', 'boolean'],
        ]);

        $cover = $validated['cover_image'] ?? '';

        if ($request->hasFile('cover_upload')) {
            $cover = PublicUpload::store($request->file('cover_upload'), 'books')['url'];
        }

        return [
            'slug' => Str::slug($validated['slug'] ?: $validated['title']),
            'title' => trim($validated['title']),
            'author' => trim($validated['author'] ?? ''),
            'category' => trim($validated['category'] ?? 'Books'),
            'description' => trim($validated['description']),
            'price' => (float) ($validated['price'] ?? 0),
            'currency' => strtoupper($validated['currency']),
            'cover_image' => $cover,
            'format' => $validated['format'],
            'pdf_url' => trim($validated['pdf_url'] ?? ''),
            'purchase_url' => trim($validated['purchase_url'] ?? ''),
            'is_available' => $request->boolean('is_available'),
        ];
    }

    private function blankBook(): array
    {
        return [
            'slug' => '',
            'title' => '',
            'author' => '',
            'category' => 'Books',
            'description' => '',
            'price' => 0,
            'currency' => 'USD',
            'cover_image' => '',
            'format' => 'pdf',
            'pdf_url' => '',
            'purchase_url' => '',
            'is_available' => true,
        ];
    }

    private function findBook(string $slug): array
    {
        $book = collect($this->editableSite()['book_products'] ?? [])
            ->first(fn (array $book): bool => ($book['slug'] ?? Str::slug($book['title'])) === $slug);

        abort_unless($book, 404);

        return [
            ...$this->blankBook(),
            ...$book,
            'slug' => $book['slug'] ?? Str::slug($book['title']),
        ];
    }

    private function editableSite(): array
    {
        $site = config('site');
        $editableSite = SiteSetting::query()->where('key', 'site')->value('value');

        if (is_array($editableSite)) {
            $site = array_replace_recursive($site, $editableSite);
        }

        unset($site['admin']);

        return $site;
    }

    private function saveSite(array $site): void
    {
        unset($site['admin']);

        SiteSetting::query()->updateOrCreate(
            ['key' => 'site'],
            ['value' => $site],
        );
    }
}
