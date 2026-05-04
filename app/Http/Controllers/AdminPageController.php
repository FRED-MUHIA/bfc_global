<?php

namespace App\Http\Controllers;

use App\Models\ContactInquiry;
use App\Models\BlogPost;
use App\Models\Donation;
use App\Models\EventRegistration;
use App\Models\MediaAsset;
use App\Models\NewsletterSubscription;
use App\Models\PageContent;
use App\Models\ProgramRegistration;
use App\Models\SiteSetting;
use App\Support\PublicUpload;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use JsonException;
use Illuminate\View\View;

class AdminPageController extends Controller
{
    public function dashboard(): View
    {
        return view('admin.dashboard', [
            'pages' => $this->pagesWithContent(),
            'maintenanceEnabled' => $this->maintenanceEnabled(),
            'contactCount' => ContactInquiry::query()->count(),
            'donationCount' => Donation::query()->count(),
            'eventRegistrationCount' => EventRegistration::query()->count(),
            'programRegistrationCount' => ProgramRegistration::query()->count(),
            'newsletterCount' => NewsletterSubscription::query()->count(),
            'mediaCount' => MediaAsset::query()->count(),
            'blogCount' => BlogPost::query()->count(),
            'latestMediaImages' => MediaAsset::query()
                ->where('mime_type', 'like', 'image/%')
                ->latest()
                ->take(4)
                ->get(),
        ]);
    }

    public function toggleMaintenance(Request $request): RedirectResponse
    {
        $enable = ! $this->maintenanceEnabled();

        SiteSetting::query()->updateOrCreate(
            ['key' => 'maintenance'],
            ['value' => ['enabled' => $enable]],
        );

        return redirect()
            ->route('admin.dashboard')
            ->with('status', $enable ? 'Maintenance mode is now on.' : 'Maintenance mode is now off.');
    }

    public function editSiteContent(): View
    {
        $siteContent = SiteSetting::query()
            ->where('key', 'site')
            ->value('value') ?? config('site');

        unset($siteContent['admin']);

        return view('admin.site-content.edit', [
            'siteJson' => json_encode($siteContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES),
        ]);
    }

    public function updateSiteContent(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'site_json' => ['required', 'string'],
        ]);

        try {
            $siteContent = json_decode($validated['site_json'], true, flags: JSON_THROW_ON_ERROR);
        } catch (JsonException) {
            return back()
                ->withErrors(['site_json' => 'The site content must be valid JSON.'])
                ->withInput();
        }

        if (! is_array($siteContent)) {
            return back()
                ->withErrors(['site_json' => 'The site content must be a JSON object.'])
                ->withInput();
        }

        unset($siteContent['admin']);

        SiteSetting::query()->updateOrCreate(
            ['key' => 'site'],
            ['value' => $siteContent],
        );

        return redirect()
            ->route('admin.site-content.edit')
            ->with('status', 'Site content saved.');
    }

    public function edit(string $page): View
    {
        $definition = $this->pageDefinition($page);
        $content = PageContent::query()->firstOrNew(['slug' => $page], [
            'title' => $definition['label'],
            'description' => '',
            'hero' => [
                'eyebrow' => '',
                'title' => $definition['label'],
                'body' => '',
                'image_url' => '',
            ],
            'sections' => [],
            'is_published' => false,
        ]);
        $pageSource = $this->pageSourceContent($definition);

        return view('admin.pages.edit', compact('definition', 'content', 'pageSource'));
    }

    public function update(Request $request, string $page): RedirectResponse
    {
        $definition = $this->pageDefinition($page);
        $validated = $request->validate([
            'page_source_uploads' => ['nullable', 'array'],
            'page_source' => ['nullable', 'array'],
        ]);

        $pageSource = $validated['page_source'] ?? [];
        $this->mergeUploadedImages($pageSource, $request->allFiles()['page_source_uploads'] ?? []);

        if ($request->has('page_source') || $request->hasFile('page_source_uploads')) {
            $this->savePageSourceContent($definition, $pageSource);
        }

        PageContent::query()->updateOrCreate(
            ['slug' => $page],
            [
                'title' => $definition['label'],
                'description' => '',
                'hero' => [],
                'sections' => [],
                'is_published' => false,
            ],
        );

        return redirect()
            ->route('admin.pages.edit', $definition['slug'])
            ->with('status', 'Page content saved.');
    }

    private function pagesWithContent(): array
    {
        $contents = PageContent::query()->get()->keyBy('slug');

        return collect($this->pageDefinitions())
            ->map(function (array $page) use ($contents): array {
                $content = $contents->get($page['slug']);

                return [
                    ...$page,
                    'content' => $content,
                    'is_published' => (bool) ($content?->is_published),
                    'updated_at' => $content?->updated_at,
                ];
            })
            ->all();
    }

    private function maintenanceEnabled(): bool
    {
        $settings = SiteSetting::query()
            ->where('key', 'maintenance')
            ->value('value');

        return (bool) data_get($settings, 'enabled', false);
    }

    private function pageDefinition(string $slug): array
    {
        $definition = collect($this->pageDefinitions())->firstWhere('slug', $slug);

        abort_unless($definition, 404);

        return $definition;
    }

    private function pageDefinitions(): array
    {
        return [
            ['slug' => 'home', 'label' => 'Home', 'path' => '/', 'source_keys' => ['home_hero_slides', 'home_about', 'organization', 'featured_resources', 'impact_stats', 'testimonials', 'blog_posts']],
            ['slug' => 'about', 'label' => 'About', 'path' => '/about', 'source_keys' => ['organization']],
            ['slug' => 'ministry-programs', 'label' => 'Ministry Programs', 'path' => '/ministry-programs', 'source_keys' => ['ministry_programs']],
            ['slug' => 'events', 'label' => 'Events', 'path' => '/events', 'source_keys' => ['events', 'event_registration_questions']],
            ['slug' => 'gallery', 'label' => 'Gallery', 'path' => '/gallery', 'source_keys' => ['gallery_photos']],
            ['slug' => 'resources-hub', 'label' => 'Resources Hub', 'path' => '/resources-hub', 'source_keys' => ['resources_hub', 'program_videos', 'sermons']],
            ['slug' => 'blog', 'label' => 'Blog Page Copy', 'path' => '/blog', 'source_keys' => []],
            ['slug' => 'get-involved', 'label' => 'Get Involved', 'path' => '/get-involved', 'source_keys' => ['involvement_opportunities']],
            ['slug' => 'donate', 'label' => 'Donate', 'path' => '/donate', 'source_keys' => ['ministry_programs', 'events']],
            ['slug' => 'contact', 'label' => 'Contact', 'path' => '/contact', 'source_keys' => ['organization']],
        ];
    }

    private function pageSourceContent(array $definition): array
    {
        $site = $this->editableSite();

        return collect($definition['source_keys'] ?? [])
            ->mapWithKeys(fn (string $key): array => [$key => data_get($site, $key)])
            ->filter(fn (mixed $value): bool => $value !== null)
            ->all();
    }

    private function savePageSourceContent(array $definition, array $pageSource): void
    {
        $site = $this->editableSite();

        foreach ($definition['source_keys'] ?? [] as $key) {
            if (array_key_exists($key, $pageSource)) {
                data_set($site, $key, $pageSource[$key]);
            }
        }

        unset($site['admin']);

        SiteSetting::query()->updateOrCreate(
            ['key' => 'site'],
            ['value' => $site],
        );
    }

    private function editableSite(): array
    {
        $site = config('site');
        $editableSite = SiteSetting::query()
            ->where('key', 'site')
            ->value('value');

        if (is_array($editableSite)) {
            $site = array_replace_recursive($site, $editableSite);
        }

        unset($site['admin']);

        return $site;
    }

    private function mergeUploadedImages(array &$content, array $uploads): void
    {
        foreach ($uploads as $key => $upload) {
            if ($upload instanceof UploadedFile) {
                $content[$key] = $this->storeUploadedImage($upload);
                continue;
            }

            if (is_array($upload)) {
                if (! isset($content[$key]) || ! is_array($content[$key])) {
                    $content[$key] = [];
                }

                $this->mergeUploadedImages($content[$key], $upload);
            }
        }
    }

    private function storeUploadedImage(UploadedFile $image): string
    {
        return PublicUpload::store($image, 'page-builder')['url'];
    }
}
