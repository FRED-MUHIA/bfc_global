<?php

namespace App\Http\Controllers;

use App\Models\BlogPost;
use App\Models\PageContent;
use App\Models\SiteSetting;
use Illuminate\Database\QueryException;
use Illuminate\Support\Str;
use Illuminate\View\View;

class PageController extends Controller
{
    public function home(): View
    {
        try {
            $blogPreviews = BlogPost::query()
                ->orderByDesc('published_at')
                ->take(3)
                ->get();
            $blogSlugs = BlogPost::query()
                ->pluck('slug')
                ->all();
        } catch (QueryException) {
            $blogPreviews = collect($this->siteData('blog_posts', []))
                ->take(3)
                ->map(fn (array $post) => (object) $post);
            $blogSlugs = collect($this->siteData('blog_posts', []))
                ->pluck('slug')
                ->all();
        }

        return $this->renderPage('home', 'pages.home', compact('blogPreviews', 'blogSlugs'));
    }

    public function about(): View
    {
        return $this->renderPage('about', 'pages.about');
    }

    public function ministryPrograms(): View
    {
        return $this->renderPage('ministry-programs', 'pages.ministry-programs');
    }

    public function ministryProgram(string $program): View
    {
        $programDetails = collect($this->siteData('ministry_programs', []))->firstWhere('slug', $program);

        abort_unless($programDetails, 404);

        return view('pages.ministry-program', [
            'program' => $programDetails,
        ]);
    }

    public function events(): View
    {
        return $this->renderPage('events', 'pages.events');
    }

    public function gallery(): View
    {
        return $this->renderPage('gallery', 'pages.gallery');
    }

    public function resourcesHub(): View
    {
        return $this->renderPage('resources-hub', 'pages.resources-hub');
    }

    public function programVideos(): View
    {
        return view('pages.program-videos');
    }

    public function sermons(): View
    {
        return view('pages.sermons', [
            'dailySermons' => collect($this->siteData('sermons.daily', [])),
            'weeklySermons' => collect($this->siteData('sermons.weekly', [])),
        ]);
    }

    public function shop(): View
    {
        return view('pages.shop');
    }

    public function bookProduct(string $book): View
    {
        $bookProduct = collect($this->siteData('book_products', []))
            ->first(fn (array $product): bool => ($product['slug'] ?? Str::slug($product['title'])) === $book);

        abort_unless($bookProduct, 404);

        return view('pages.book-product', [
            'book' => [
                ...$bookProduct,
                'slug' => $bookProduct['slug'] ?? Str::slug($bookProduct['title']),
            ],
        ]);
    }

    public function blog(): View
    {
        try {
            $posts = BlogPost::query()
                ->orderByDesc('published_at')
                ->get();
        } catch (QueryException) {
            $posts = collect($this->siteData('blog_posts', []))
                ->map(fn (array $post) => (object) $post);
        }

        return $this->renderPage('blog', 'pages.blog', compact('posts'));
    }

    public function blogArticle(string $slug): View
    {
        try {
            $post = BlogPost::query()
                ->where('slug', $slug)
                ->firstOrFail();
        } catch (QueryException) {
            $fallback = collect($this->siteData('blog_posts', []))
                ->firstWhere('slug', $slug);

            abort_unless($fallback, 404);
            $post = (object) $fallback;
        }

        return view('pages.blog-article', compact('post'));
    }

    public function getInvolved(): View
    {
        return $this->renderPage('get-involved', 'pages.get-involved');
    }

    public function donate(): View
    {
        $donationSettings = $this->siteData('donation_settings', []);
        $paypalClientId = $donationSettings['paypal_client_id'] ?? config('services.paypal.client_id');
        $paypalEnabled = (bool) ($donationSettings['paypal_enabled'] ?? filled($paypalClientId));

        return $this->renderPage('donate', 'pages.donate', [
            'paypalClientId' => $paypalEnabled ? $paypalClientId : null,
            'paypalCurrency' => strtoupper($donationSettings['paypal_currency'] ?? config('services.paypal.currency', 'USD')),
            'paypalMode' => $donationSettings['paypal_mode'] ?? 'sandbox',
        ]);
    }

    public function contact(): View
    {
        return $this->renderPage('contact', 'pages.contact');
    }

    private function renderPage(string $slug, string $fallbackView, array $data = []): View
    {
        try {
            $pageContent = PageContent::query()
                ->where('slug', $slug)
                ->where('is_published', true)
                ->first();
        } catch (QueryException) {
            $pageContent = null;
        }

        if ($pageContent && collect($pageContent->sections ?? [])->isNotEmpty()) {
            return view('pages.builder-show', [
                ...$data,
                'pageContent' => $pageContent,
                'title' => $pageContent->title,
                'description' => $pageContent->description,
            ]);
        }

        return view($fallbackView, $data);
    }

    private function siteData(string $key, mixed $default = null): mixed
    {
        try {
            $editableSite = SiteSetting::query()
                ->where('key', 'site')
                ->value('value');
        } catch (QueryException) {
            $editableSite = null;
        }

        return data_get($editableSite, $key, config('site.' . $key, $default));
    }
}
