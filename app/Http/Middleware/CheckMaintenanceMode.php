<?php

namespace App\Http\Middleware;

use App\Models\SiteSetting;
use Closure;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CheckMaintenanceMode
{
    public function handle(Request $request, Closure $next): Response
    {
        if ($request->session()->get('admin_authenticated')) {
            return $next($request);
        }

        if ($request->is('storage/*', 'build/*', 'favicon.ico')) {
            return $next($request);
        }

        if ($request->is('admin*')) {
            return $next($request);
        }

        if (! $this->maintenanceEnabled()) {
            return $next($request);
        }

        return response()
            ->view('errors.maintenance', [], 503)
            ->header('Retry-After', '3600');
    }

    private function maintenanceEnabled(): bool
    {
        try {
            $settings = SiteSetting::query()
                ->where('key', 'maintenance')
                ->value('value');
        } catch (QueryException) {
            return false;
        }

        return (bool) data_get($settings, 'enabled', false);
    }
}
