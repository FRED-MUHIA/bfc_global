<!DOCTYPE html>
<html lang="en">
@php
    $adminBranding = $site['branding'] ?? config('site.branding', []);
    $adminSiteName = $adminBranding['site_name'] ?? config('site.organization.short_name');
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $title ?? 'Admin' }} | {{ $adminSiteName }}</title>
    @if (!empty($adminBranding['favicon_url']))
        <link rel="icon" href="{{ $adminBranding['favicon_url'] }}">
    @endif
    @if (!app()->environment('testing'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-cream text-slate">
    <div class="min-h-screen">
        <header class="border-b border-sand bg-white/90">
            <div class="container-base flex min-h-16 flex-wrap items-center justify-between gap-3 py-3">
                <a href="{{ route('admin.dashboard') }}" class="font-heading text-xl font-semibold text-pine">Admin Dashboard</a>
                <div class="flex items-center gap-2">
                    <a href="{{ route('home') }}" class="rounded-full px-4 py-2 text-sm font-semibold text-slate hover:bg-mist">View Site</a>
                    @if (session('admin_authenticated'))
                        <form method="POST" action="{{ route('admin.logout') }}">
                            @csrf
                            <button type="submit" class="rounded-full bg-pine px-4 py-2 text-sm font-semibold text-white hover:bg-sage">Sign Out</button>
                        </form>
                    @endif
                </div>
            </div>
        </header>

        <main class="container-base py-8">
            @if (session('status'))
                <div class="mb-6 rounded-lg border border-sage/30 bg-mist px-4 py-3 text-sm font-semibold text-pine">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const maxUploadSize = 20 * 1024 * 1024;

            document.querySelectorAll('form[enctype="multipart/form-data"]').forEach((form) => {
                form.addEventListener('submit', (event) => {
                    const oversizedFile = Array.from(form.querySelectorAll('input[type="file"]'))
                        .flatMap((input) => Array.from(input.files || []))
                        .find((file) => file.size > maxUploadSize);

                    if (oversizedFile) {
                        event.preventDefault();
                        alert(`"${oversizedFile.name}" is too large. Please upload an image under 20 MB.`);
                    }
                });
            });
        });
    </script>
</body>
</html>
