<!DOCTYPE html>
<html lang="en">
@php
    $site = $site ?? config('site');
    $siteName = $site['branding']['site_name'] ?? $site['organization']['name'] ?? config('app.name');
@endphp
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="robots" content="noindex">
    <title>Maintenance | {{ $siteName }}</title>
    @if (!empty($site['branding']['favicon_url']))
        <link rel="icon" href="{{ $site['branding']['favicon_url'] }}">
    @endif
    @if (!app()->environment('testing'))
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    @endif
</head>
<body class="bg-white text-slate">
    <main class="min-h-screen overflow-hidden bg-white">
        <section class="container-base grid min-h-screen items-center gap-10 py-12 lg:grid-cols-[1fr_0.95fr]">
            <div class="max-w-2xl">
                <p class="text-sm font-extrabold uppercase tracking-[0.18em] text-ember">Maintenance</p>
                <h1 class="mt-4 text-5xl font-bold leading-tight text-pine sm:text-6xl">We are tidying up!</h1>
                <p class="mt-5 text-2xl font-semibold text-slate">Sorry for the inconvenience.</p>
                <p class="mt-5 max-w-xl text-lg text-slate/75">
                    We are currently updating the website to improve your experience. Thank you for your patience.
                </p>
                <p class="mt-10 text-sm font-bold uppercase tracking-[0.12em] text-slate/70">Please check back soon</p>
            </div>

            <div class="relative mx-auto h-[420px] w-full max-w-lg">
                <div class="absolute left-1/2 top-4 h-[380px] w-56 -translate-x-1/2 rounded-lg bg-slate/80 p-5 shadow-soft">
                    @foreach (range(1, 5) as $row)
                        <div class="mb-5 rounded-md border border-white/40 bg-white/10 p-3">
                            <div class="flex h-11 items-end gap-1">
                                @foreach ([30, 54, 42, 72, 85, 58, 76, 38, 66, 24] as $height)
                                    <span class="block w-2 rounded-t bg-white/80" style="height: {{ max(10, $height - ($row * 4)) }}%;"></span>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                </div>
                <div class="absolute bottom-8 left-2 h-28 w-44 rounded-lg border border-sand bg-white shadow-soft">
                    <div class="mx-auto mt-7 h-14 w-20 rounded-md bg-slate/80"></div>
                    <div class="mx-auto mt-3 h-2 w-28 rounded-full bg-sand"></div>
                </div>
                <div class="absolute bottom-6 right-4 h-48 w-28">
                    <div class="mx-auto h-14 w-14 rounded-full bg-slate"></div>
                    <div class="mx-auto mt-2 h-24 w-20 rounded-t-full bg-coral"></div>
                    <div class="mx-auto mt-2 h-20 w-2 rounded-full bg-slate"></div>
                    <div class="absolute right-0 top-28 h-28 w-2 rotate-12 rounded-full bg-slate"></div>
                </div>
                <div class="absolute right-0 top-8 h-16 w-16 rounded-full border-[12px] border-mist"></div>
                <div class="absolute right-12 top-24 h-12 w-12 rounded-full border-[10px] border-sand"></div>
            </div>
        </section>
    </main>
</body>
</html>
