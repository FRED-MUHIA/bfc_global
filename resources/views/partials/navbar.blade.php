@php
    $programPaths = [
        '/ministry-programs',
    ];
    $branding = $site['branding'] ?? [];
    $mainNavigationBeforePrograms = collect($site['navigation'])->filter(fn ($item) => in_array($item['path'], ['/', '/about'], true));
    $mainNavigationAfterPrograms = collect($site['navigation'])->filter(fn ($item) => in_array($item['path'], ['/events', '/gallery', '/resources-hub', '/blog', '/contact'], true));
    $programNavigation = collect($site['navigation'])->filter(fn ($item) => in_array($item['path'], $programPaths, true));
    $ministryProgramNavigation = collect($site['ministry_programs'] ?? []);
    $brandName = $branding['site_name'] ?? $site['organization']['short_name'];
    $brandTagline = $branding['tagline'] ?? $site['organization']['tagline'] ?? 'Family and Community Care';
    $joinLabel = $branding['join_label'] ?? 'Join Us';
    $joinUrl = $branding['join_url'] ?? '/get-involved';
    $donateLabel = $branding['donate_label'] ?? 'Donate';
    $donateUrl = $branding['donate_url'] ?? '/donate';
    $programIsActive = $programNavigation->contains(function ($item) {
        $itemPath = trim($item['path'], '/');

        return request()->is($itemPath) || request()->is($itemPath . '/*');
    }) || request()->is('ministry-programs/*');
@endphp

<nav class="fixed inset-x-0 top-0 z-50 border-b border-sand/70 bg-cream/90 backdrop-blur-md">
    <div class="container-base flex h-20 items-center justify-between gap-6">
        <a href="{{ route('home') }}" class="group flex items-center gap-3">
            @if (!empty($branding['logo_url']))
                <img src="{{ $branding['logo_url'] }}" alt="{{ $brandName }}" class="max-h-14 w-auto max-w-[210px] object-contain">
            @else
                <span>
                    <span class="block font-heading text-lg font-semibold text-pine transition group-hover:text-ember md:text-xl">
                        {{ $brandName }}
                    </span>
                    <span class="block text-xs font-semibold uppercase tracking-[0.12em] text-sage">{{ $brandTagline }}</span>
                </span>
            @endif
        </a>

        <button
            type="button"
            id="mobile-menu-toggle"
            aria-expanded="false"
            aria-controls="mobile-menu"
            class="inline-flex h-11 items-center justify-center rounded-lg bg-pine px-4 text-sm font-semibold text-white shadow-sm transition hover:bg-sage lg:hidden"
        >
            Menu
        </button>

        <div class="hidden items-center gap-2 lg:flex">
            @foreach ($mainNavigationBeforePrograms as $item)
                @php
                    $itemPath = trim($item['path'], '/');
                    $isActive = $item['path'] === '/'
                        ? request()->path() === '/'
                        : request()->is($itemPath) || request()->is($itemPath . '/*');
                @endphp
                <a
                    href="{{ url($item['path']) }}"
                    class="rounded-full px-3 py-2 text-sm font-semibold transition {{ $isActive ? 'bg-mist text-pine' : 'text-slate hover:bg-mist/70 hover:text-pine' }}"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
            <div class="group relative">
                <button type="button" class="rounded-full px-3 py-2 text-sm font-semibold transition {{ $programIsActive ? 'bg-mist text-pine' : 'text-slate hover:bg-mist/70 hover:text-pine' }}">
                    Our Programs
                </button>
                <div class="invisible absolute left-0 top-full z-30 mt-3 max-h-[75vh] w-80 translate-y-2 overflow-y-auto rounded-2xl border border-sand bg-white p-3 opacity-0 shadow-soft transition group-hover:visible group-hover:translate-y-0 group-hover:opacity-100 group-focus-within:visible group-focus-within:translate-y-0 group-focus-within:opacity-100">
                    @foreach ($programNavigation as $item)
                        @php
                            $itemPath = trim($item['path'], '/');
                            $isActive = request()->is($itemPath) || request()->is($itemPath . '/*');
                        @endphp
                        <a
                            href="{{ url($item['path']) }}"
                            class="block rounded-xl px-4 py-3 text-sm font-semibold transition {{ $isActive ? 'bg-mist text-pine' : 'text-slate hover:bg-mist/70 hover:text-pine' }}"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                    <div class="my-2 border-t border-sand"></div>
                    <p class="px-4 pb-2 pt-1 text-xs font-bold uppercase tracking-[0.13em] text-ember">Ministry Programs</p>
                    @foreach ($ministryProgramNavigation as $program)
                        @php
                            $isActive = request()->is('ministry-programs/' . $program['slug']);
                        @endphp
                        <a
                            href="{{ route('ministry-programs.show', $program['slug']) }}"
                            class="block rounded-xl px-4 py-3 text-sm font-semibold transition {{ $isActive ? 'bg-mist text-pine' : 'text-slate hover:bg-mist/70 hover:text-pine' }}"
                        >
                            {{ $program['menu_label'] ?? $program['title'] }}
                        </a>
                    @endforeach
                </div>
            </div>
            @foreach ($mainNavigationAfterPrograms as $item)
                @php
                    $itemPath = trim($item['path'], '/');
                    $isActive = request()->is($itemPath) || request()->is($itemPath . '/*');
                @endphp
                <a
                    href="{{ url($item['path']) }}"
                    class="rounded-full px-3 py-2 text-sm font-semibold transition {{ $isActive ? 'bg-mist text-pine' : 'text-slate hover:bg-mist/70 hover:text-pine' }}"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>

        <div class="hidden items-center gap-2 md:flex">
            <a href="{{ url($joinUrl) }}" class="inline-flex items-center justify-center rounded-full bg-pine px-4 py-2 text-sm font-semibold tracking-wide text-white transition hover:bg-sage">
                {{ $joinLabel }}
            </a>
            <a href="{{ url($donateUrl) }}" class="inline-flex items-center justify-center rounded-full bg-ember px-4 py-2 text-sm font-semibold tracking-wide text-white transition hover:bg-ember/90">
                {{ $donateLabel }}
            </a>
        </div>
    </div>

    <div id="mobile-menu" class="hidden border-t border-sand bg-cream px-4 pb-5 pt-3 lg:hidden">
        <div class="container-base grid gap-2 px-0">
            @foreach ($mainNavigationBeforePrograms as $item)
                @php
                    $itemPath = trim($item['path'], '/');
                    $isActive = $item['path'] === '/'
                        ? request()->path() === '/'
                        : request()->is($itemPath) || request()->is($itemPath . '/*');
                @endphp
                <a
                    href="{{ url($item['path']) }}"
                    class="rounded-lg px-3 py-2 text-sm font-semibold {{ $isActive ? 'bg-mist text-pine' : 'text-slate hover:bg-mist/60' }}"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
            <div class="rounded-xl border border-sand/80 bg-white/50 p-2">
                <p class="px-3 pb-1 text-xs font-bold uppercase tracking-[0.13em] text-ember">Our Programs</p>
                <div class="grid gap-1">
                    @foreach ($programNavigation as $item)
                        @php
                            $itemPath = trim($item['path'], '/');
                            $isActive = request()->is($itemPath) || request()->is($itemPath . '/*');
                        @endphp
                        <a
                            href="{{ url($item['path']) }}"
                            class="rounded-lg px-3 py-2 text-sm font-semibold {{ $isActive ? 'bg-mist text-pine' : 'text-slate hover:bg-mist/60' }}"
                        >
                            {{ $item['label'] }}
                        </a>
                    @endforeach
                    <p class="px-3 pb-1 pt-3 text-xs font-bold uppercase tracking-[0.13em] text-ember">Ministry Programs</p>
                    @foreach ($ministryProgramNavigation as $program)
                        @php
                            $isActive = request()->is('ministry-programs/' . $program['slug']);
                        @endphp
                        <a
                            href="{{ route('ministry-programs.show', $program['slug']) }}"
                            class="rounded-lg px-3 py-2 text-sm font-semibold {{ $isActive ? 'bg-mist text-pine' : 'text-slate hover:bg-mist/60' }}"
                        >
                            {{ $program['menu_label'] ?? $program['title'] }}
                        </a>
                    @endforeach
                </div>
            </div>
            @foreach ($mainNavigationAfterPrograms as $item)
                @php
                    $itemPath = trim($item['path'], '/');
                    $isActive = request()->is($itemPath) || request()->is($itemPath . '/*');
                @endphp
                <a
                    href="{{ url($item['path']) }}"
                    class="rounded-lg px-3 py-2 text-sm font-semibold {{ $isActive ? 'bg-mist text-pine' : 'text-slate hover:bg-mist/60' }}"
                >
                    {{ $item['label'] }}
                </a>
            @endforeach
            <div class="mt-2 flex flex-wrap gap-2">
                <a href="{{ url($joinUrl) }}" class="inline-flex flex-1 items-center justify-center rounded-full bg-pine px-5 py-3 text-sm font-semibold tracking-wide text-white transition hover:bg-sage">
                    {{ $joinLabel }}
                </a>
                <a href="{{ url($donateUrl) }}" class="inline-flex flex-1 items-center justify-center rounded-full bg-ember px-5 py-3 text-sm font-semibold tracking-wide text-white transition hover:bg-ember/90">
                    {{ $donateLabel }}
                </a>
            </div>
        </div>
    </div>
</nav>
