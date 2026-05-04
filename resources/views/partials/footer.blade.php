<footer class="border-t border-sand bg-white/80">
    <div class="container-base grid gap-10 py-14 md:grid-cols-3">
        <div>
            <h3 class="text-2xl">{{ $site['organization']['short_name'] }}</h3>
            <p class="mt-3 max-w-sm text-sm text-slate/80">{{ $site['organization']['mission'] }}</p>
        </div>

        <div>
            <h4 class="text-lg">Explore</h4>
            <div class="mt-3 grid grid-cols-1 gap-2 sm:grid-cols-2">
                @foreach ($site['navigation'] as $item)
                    <a href="{{ url($item['path']) }}" class="text-sm text-slate/80 hover:text-pine">{{ $item['label'] }}</a>
                @endforeach
            </div>
        </div>

        <div>
            <h4 class="text-lg">Contact</h4>
            <p class="mt-3 text-sm text-slate/80">{{ $site['organization']['contact']['location'] }}</p>
            <p class="mt-2 text-sm text-slate/80">{{ $site['organization']['contact']['phone'] }}</p>
            <p class="mt-2 text-sm text-slate/80">{{ $site['organization']['contact']['email'] }}</p>
            <p class="mt-2 text-sm text-slate/70">{{ $site['organization']['contact']['hours'] }}</p>
        </div>
    </div>
    <div class="border-t border-sand py-4">
        <p class="container-base text-center text-xs tracking-wide text-slate/60">
            &copy; {{ now()->year }} {{ $site['organization']['name'] }}. All rights reserved.
        </p>
    </div>
</footer>
