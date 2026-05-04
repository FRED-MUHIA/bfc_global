@extends('layouts.admin', ['title' => 'Event Management'])

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-4xl">Event Management</h1>
            <p class="mt-2 text-slate/75">Create, edit, delete, and review public events.</p>
        </div>
        <a href="{{ route('admin.events.create') }}" class="rounded-full bg-pine px-5 py-3 text-sm font-bold text-white hover:bg-sage">Add Event</a>
    </div>

    <section class="mt-7 overflow-hidden rounded-lg border border-sand bg-white">
        <div class="divide-y divide-sand">
            @forelse ($events as $event)
                <div class="grid gap-4 p-5 lg:grid-cols-[8rem_1fr_auto] lg:items-center">
                    <img src="{{ $event['image'] }}" alt="{{ $event['title'] }}" class="aspect-[4/3] w-full rounded-lg object-cover lg:w-32">
                    <div>
                        <div class="flex flex-wrap items-center gap-2">
                            <h2 class="text-2xl">{{ $event['title'] }}</h2>
                            <span class="rounded-full bg-mist px-3 py-1 text-xs font-bold uppercase tracking-[0.12em] text-pine">{{ $event['category'] }}</span>
                            <span class="rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.12em] {{ ($event['registration_open'] ?? true) ? 'bg-mist text-pine' : 'bg-sand text-slate' }}">
                                {{ ($event['registration_open'] ?? true) ? 'Registration Open' : 'Registration Closed' }}
                            </span>
                        </div>
                        <p class="mt-2 text-sm text-slate/75">{{ $event['date'] }} • {{ $event['time'] }} • {{ $event['location'] }}</p>
                        <p class="mt-2 text-sm text-slate/75">{{ $event['description'] }}</p>
                        <p class="mt-2 text-xs font-bold uppercase tracking-[0.12em] text-ember">{{ $event['registrations_count'] }} registrations</p>
                    </div>
                    <div class="flex flex-wrap gap-2 lg:justify-end">
                        <a href="{{ url('/events#event-' . $event['slug']) }}" class="rounded-full border border-sand px-4 py-2 text-sm font-bold text-slate hover:bg-mist">Preview</a>
                        <a href="{{ route('event.register', ['event' => $event['slug']]) }}" class="rounded-full border border-sand px-4 py-2 text-sm font-bold text-slate hover:bg-mist">Form</a>
                        <a href="{{ route('admin.event-registrations.index') }}" class="rounded-full border border-sand px-4 py-2 text-sm font-bold text-slate hover:bg-mist">Registrations</a>
                        <form method="POST" action="{{ route('admin.events.toggle-registration', $event['slug']) }}">
                            @csrf
                            @method('PATCH')
                            <button type="submit" class="rounded-full border border-sand px-4 py-2 text-sm font-bold text-pine hover:bg-mist">
                                {{ ($event['registration_open'] ?? true) ? 'Close Registration' : 'Open Registration' }}
                            </button>
                        </form>
                        <a href="{{ route('admin.events.edit', $event['slug']) }}" class="rounded-full bg-pine px-4 py-2 text-sm font-bold text-white hover:bg-sage">Edit</a>
                        <form method="POST" action="{{ route('admin.events.destroy', $event['slug']) }}" onsubmit="return confirm('Delete this event?');">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="rounded-full border border-red-200 px-4 py-2 text-sm font-bold text-red-700 hover:bg-red-50">Delete</button>
                        </form>
                    </div>
                </div>
            @empty
                <div class="p-8 text-center text-slate/70">No events yet.</div>
            @endforelse
        </div>
    </section>
@endsection
