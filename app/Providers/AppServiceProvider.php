<?php

namespace App\Providers;

use App\Models\SiteSetting;
use Illuminate\Database\QueryException;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\View;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        View::share('site', $this->siteContent());
    }

    private function siteContent(): array
    {
        $site = config('site');

        try {
            $editableSite = SiteSetting::query()
                ->where('key', 'site')
                ->value('value');
        } catch (QueryException) {
            $editableSite = null;
        }

        if (! is_array($editableSite)) {
            return $site;
        }

        return array_replace_recursive($site, $editableSite);
    }
}
