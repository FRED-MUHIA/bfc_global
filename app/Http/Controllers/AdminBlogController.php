<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\SiteSetting;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminBlogController extends Controller
{
    public function index(): View
    {
        return view('admin.blog.index', [
            'posts' => BlogPost::query()->orderByDesc('published_at')->paginate(20),
            'categories' => $this->categories(),
            'categoryPostCounts' => BlogPost::query()
                ->pluck('category')
                ->countBy()
                ->all(),
        ]);
    }

    public function create(): View
    {
        return view('admin.blog.form', [
            'post' => new BlogPost([
                'published_at' => now(),
                'author' => 'BFC Global Trust',
                'read_time' => '5 min read',
                'content' => [
                    ['heading' => 'Article Section', 'paragraphs' => ['Write your paragraph here.']],
                ],
            ]),
            'mode' => 'create',
            'categories' => $this->categories(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validatedData($request);

        BlogPost::query()->create($data);

        return redirect()
            ->route('admin.blog.index')
            ->with('status', 'Blog post created.');
    }

    public function edit(BlogPost $blog): View
    {
        return view('admin.blog.form', [
            'post' => $blog,
            'mode' => 'edit',
            'categories' => $this->categories($blog->category),
        ]);
    }

    public function update(Request $request, BlogPost $blog): RedirectResponse
    {
        $blog->update($this->validatedData($request, $blog));

        return redirect()
            ->route('admin.blog.index')
            ->with('status', 'Blog post saved.');
    }

    public function destroy(BlogPost $blog): RedirectResponse
    {
        $blog->delete();

        return redirect()
            ->route('admin.blog.index')
            ->with('status', 'Blog post deleted.');
    }

    public function storeCategory(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'category' => ['required', 'string', 'max:120'],
        ]);

        $category = trim($validated['category']);
        $categories = collect($this->categories())
            ->push($category)
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        $this->saveCategories($categories);

        return redirect()
            ->route('admin.blog.index')
            ->with('status', 'Blog category added.');
    }

    public function destroyCategory(string $category): RedirectResponse
    {
        $category = urldecode($category);

        if (BlogPost::query()->where('category', $category)->exists()) {
            return redirect()
                ->route('admin.blog.index')
                ->withErrors(['category' => 'This category is used by one or more blog posts. Update those posts before removing it.']);
        }

        $categories = collect($this->categories())
            ->reject(fn (string $existing): bool => $existing === $category)
            ->values()
            ->all();

        $this->saveCategories($categories);

        return redirect()
            ->route('admin.blog.index')
            ->with('status', 'Blog category removed.');
    }

    private function validatedData(Request $request, ?BlogPost $post = null): array
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['nullable', 'string', 'max:180'],
            'excerpt' => ['required', 'string', 'max:600'],
            'category' => ['nullable', 'string', 'max:120', 'required_without:new_category'],
            'new_category' => ['nullable', 'string', 'max:120'],
            'image' => ['nullable', 'string', 'max:1000'],
            'image_upload' => ['nullable', 'image', 'max:20480'],
            'author' => ['required', 'string', 'max:120'],
            'published_at' => ['required', 'date'],
            'date_label' => ['nullable', 'string', 'max:120'],
            'read_time' => ['required', 'string', 'max:80'],
            'content' => ['required', 'array', 'min:1'],
            'content.*.heading' => ['required', 'string', 'max:180'],
            'content.*.paragraphs_text' => ['required', 'string'],
        ]);

        $slug = $validated['slug'] ?: Str::slug($validated['title']);
        $baseSlug = $slug;
        $counter = 2;

        while (BlogPost::query()
            ->where('slug', $slug)
            ->when($post, fn ($query) => $query->whereKeyNot($post->getKey()))
            ->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        $image = $validated['image'] ?? $post?->image ?? '';
        if ($request->hasFile('image_upload')) {
            $image = PublicUpload::store($request->file('image_upload'), 'blog')['url'];
        }

        $publishedAt = date_create($validated['published_at']);

        $category = trim($validated['new_category'] ?? '') ?: trim($validated['category'] ?? '');
        $this->rememberCategory($category);

        return [
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'],
            'category' => $category,
            'image' => $image,
            'author' => $validated['author'],
            'published_at' => $validated['published_at'],
            'date_label' => $validated['date_label'] ?: $publishedAt->format('F j, Y'),
            'read_time' => $validated['read_time'],
            'content' => collect($validated['content'])
                ->map(fn (array $section): array => [
                    'heading' => $section['heading'],
                    'paragraphs' => collect(preg_split('/\R{2,}/', trim($section['paragraphs_text'])) ?: [])
                        ->map(fn ($paragraph) => trim($paragraph))
                        ->filter()
                        ->values()
                        ->all(),
                ])
                ->filter(fn (array $section): bool => filled($section['heading']) && ! empty($section['paragraphs']))
                ->values()
                ->all(),
        ];
    }

    private function categories(?string $currentCategory = null): array
    {
        return collect($this->savedCategories())
            ->merge(BlogPost::query()->distinct()->pluck('category'))
            ->when($currentCategory, fn ($categories) => $categories->push($currentCategory))
            ->filter()
            ->map(fn (string $category): string => trim($category))
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    private function savedCategories(): array
    {
        $categories = SiteSetting::query()
            ->where('key', 'blog_categories')
            ->value('value');

        if (is_array($categories)) {
            return $categories;
        }

        return collect(config('site.blog_categories', []))
            ->merge(collect(config('site.blog_posts', []))->pluck('category'))
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();
    }

    private function rememberCategory(string $category): void
    {
        if ($category === '') {
            return;
        }

        $categories = collect($this->categories())
            ->push($category)
            ->filter()
            ->unique()
            ->sort()
            ->values()
            ->all();

        $this->saveCategories($categories);
    }

    private function saveCategories(array $categories): void
    {
        SiteSetting::query()->updateOrCreate(
            ['key' => 'blog_categories'],
            ['value' => array_values($categories)],
        );
    }
}
