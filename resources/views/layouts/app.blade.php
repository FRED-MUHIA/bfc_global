<!DOCTYPE html>
<html lang="en">
@php
    $siteName = $site['branding']['site_name'] ?? $site['organization']['name'];
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ isset($title) ? $title . ' | ' . $siteName : $siteName }}</title>
    <meta name="description" content="{{ $description ?? $site['organization']['mission'] }}">
    @if (!empty($site['branding']['favicon_url']))
        <link rel="icon" href="{{ $site['branding']['favicon_url'] }}">
    @endif
    @if (!app()->environment('testing'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body>
    <div class="flex min-h-screen flex-col bg-cream text-slate">
        @include('partials.navbar')
        <main class="flex-1 pt-20">
            @yield('content')
        </main>
        @include('partials.footer')
        @include('partials.whatsapp-button')
    </div>
</body>
</html>
