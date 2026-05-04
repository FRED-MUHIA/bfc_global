@extends('layouts.app', [
    'title' => 'Events',
    'description' => 'Upcoming BFC Global Trust workshops, family forums, youth gatherings, and community discipleship events.',
])

@section('content')
    @include('partials.page-header', [
        'eyebrow' => 'Events',
        'headerTitle' => 'Gatherings that equip families for discipleship and influence',
        'headerDescription' => 'Join our upcoming workshops, forums, and community gatherings for parents, young people, Christian leaders, churches, and families.',
        'primaryAction' => ['label' => 'Contact Events Team', 'to' => '/contact'],
        'secondaryAction' => ['label' => 'Donate to an Event', 'to' => '/donate'],
    ])

    <section class="py-16 md:py-20">
        <div class="container-base">
            @if (session('status'))
                <div class="mb-6 rounded-2xl border border-ember/30 bg-ember/10 p-4 text-sm font-semibold text-pine">
                    {{ session('status') }}
                </div>
            @endif

            <div class="mb-10 max-w-3xl">
                <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">Upcoming Events</p>
                <h2 class="mt-3 text-3xl leading-tight md:text-4xl">Training, fellowship, and transformation spaces</h2>
                <p class="mt-4 text-base text-slate/80 md:text-lg">
                    These gatherings are designed to equip homes, churches, young people, and leaders with practical family-based discipleship.
                </p>
            </div>

            <div class="grid gap-6 lg:grid-cols-3">
                @foreach (($site['events'] ?? []) as $event)
                    @php
                        $eventSlug = $event['slug'] ?? str($event['title'])->slug();
                        $eventShareUrl = url('/events') . '#event-' . $eventSlug;
                        $registrationOpen = $event['registration_open'] ?? true;
                    @endphp
                    <article class="overflow-hidden rounded-3xl border border-sand bg-white shadow-soft transition hover:-translate-y-1">
                        <img src="{{ $event['image'] }}" alt="{{ $event['title'] }}" class="h-52 w-full object-cover" loading="lazy">
                        <div id="event-{{ $eventSlug }}" class="p-6">
                            <div class="flex flex-wrap items-center justify-between gap-2">
                                <p class="text-xs font-bold uppercase tracking-[0.12em] text-ember">{{ $event['category'] }}</p>
                                <span class="rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.1em] {{ $registrationOpen ? 'bg-mist text-pine' : 'bg-sand text-slate' }}">
                                    {{ $registrationOpen ? 'Open for Registration' : 'Registration Closed' }}
                                </span>
                            </div>
                            <h3 class="mt-2 text-2xl leading-tight">{{ $event['title'] }}</h3>
                            <div class="mt-4 grid gap-1 text-sm text-slate/75">
                                <p><span class="font-semibold text-pine">Date:</span> {{ $event['date'] }}</p>
                                <p><span class="font-semibold text-pine">Time:</span> {{ $event['time'] }}</p>
                                <p><span class="font-semibold text-pine">Venue:</span> {{ $event['location'] }}</p>
                            </div>
                            <p class="mt-4 text-sm text-slate/80">{{ $event['description'] }}</p>
                            <div class="mt-6 flex flex-nowrap items-center gap-2">
                                @if ($registrationOpen)
                                    <a href="{{ route('event.register', ['event' => $eventSlug]) }}" class="inline-flex min-w-0 flex-1 items-center justify-center rounded-full bg-pine px-3 py-3 text-xs font-semibold tracking-wide text-white transition hover:bg-sage sm:text-sm">
                                        Register Interest
                                    </a>
                                @else
                                    <span class="inline-flex min-w-0 flex-1 items-center justify-center rounded-full bg-sand px-3 py-3 text-xs font-semibold tracking-wide text-slate sm:text-sm">
                                        Closed
                                    </span>
                                @endif
                                <a href="{{ route('donate') }}" class="inline-flex min-w-0 flex-1 items-center justify-center rounded-full border border-sage/30 px-3 py-3 text-xs font-semibold tracking-wide text-pine transition hover:bg-sage/10 sm:text-sm">
                                    Sponsor Event
                                </a>
                                <button
                                    type="button"
                                    data-share-event
                                    data-share-title="{{ $event['title'] }}"
                                    data-share-text="{{ $event['description'] }}"
                                    data-share-url="{{ $eventShareUrl }}"
                                    class="inline-flex h-10 w-10 shrink-0 items-center justify-center rounded-full border border-sage/30 text-pine transition hover:bg-sage/10"
                                    aria-label="Share {{ $event['title'] }}"
                                    title="Share"
                                >
                                    <svg viewBox="0 0 24 24" aria-hidden="true" class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <circle cx="18" cy="5" r="3"></circle>
                                        <circle cx="6" cy="12" r="3"></circle>
                                        <circle cx="18" cy="19" r="3"></circle>
                                        <path d="M8.6 10.7 15.4 6.3"></path>
                                        <path d="M8.6 13.3 15.4 17.7"></path>
                                    </svg>
                                </button>
                            </div>
                            <p data-share-status class="mt-3 hidden text-xs font-semibold text-sage">Link copied</p>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="bg-white/70 py-16 md:py-20">
        <div class="container-base">
            <div class="grid items-center gap-8 lg:grid-cols-[0.9fr_1.1fr]">
                <div>
                    <p class="text-sm font-bold uppercase tracking-[0.15em] text-ember">Host or Partner</p>
                    <h2 class="mt-3 text-3xl leading-tight md:text-4xl">Bring a BFC Global Trust event to your church, school, or organization</h2>
                </div>
                <div class="glass-panel p-6 md:p-8">
                    <p class="text-base leading-8 text-slate/85 md:text-lg">
                        We partner with churches, learning institutions, community leaders, and organizations to facilitate deliberations, training, and equipping around family-based discipleship.
                    </p>
                    <div class="mt-7 flex flex-wrap gap-3">
                        <a href="{{ route('contact') }}" class="inline-flex items-center justify-center rounded-full bg-pine px-6 py-3 text-base font-semibold tracking-wide text-white transition hover:bg-sage">
                            Plan an Event
                        </a>
                        <a href="{{ route('get-involved') }}" class="inline-flex items-center justify-center rounded-full border border-sage/30 px-6 py-3 text-base font-semibold tracking-wide text-pine transition hover:bg-sage/10">
                            Volunteer
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-share-event]').forEach((button) => {
                button.addEventListener('click', async () => {
                    const shareData = {
                        title: button.dataset.shareTitle,
                        text: button.dataset.shareTitle,
                        url: button.dataset.shareUrl,
                    };
                    const status = button.closest('div')?.querySelector('[data-share-status]');

                    try {
                        if (navigator.share) {
                            await navigator.share(shareData);
                        } else {
                            await navigator.clipboard.writeText(shareData.url);
                            status?.classList.remove('hidden');
                            setTimeout(() => status?.classList.add('hidden'), 2200);
                        }
                    } catch (error) {
                        if (error.name !== 'AbortError') {
                            status?.classList.remove('hidden');
                            status.textContent = 'Share failed. Copy the page link from your browser.';
                        }
                    }
                });
            });
        });
    </script>
@endsection
