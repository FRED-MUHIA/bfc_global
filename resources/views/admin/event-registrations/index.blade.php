@extends('layouts.admin', ['title' => 'Event Registrations'])

@section('content')
    <div class="flex flex-wrap items-center justify-between gap-4">
        <div>
            <h1 class="text-4xl">Event Registrations</h1>
            <p class="mt-2 text-slate/75">View and export event registration submissions.</p>
        </div>
        <a href="{{ route('admin.event-registrations.export') }}" class="rounded-full bg-ember px-5 py-3 text-sm font-bold text-white hover:bg-ember/90">Export CSV</a>
    </div>

    <section class="mt-7 overflow-hidden rounded-lg border border-sand bg-white">
        <div class="overflow-x-auto">
            <table class="w-full min-w-[760px] text-left text-sm">
                <thead class="bg-mist text-pine">
                    <tr>
                        <th class="px-4 py-3">Name</th>
                        <th class="px-4 py-3">Email</th>
                        <th class="px-4 py-3">Phone</th>
                        <th class="px-4 py-3">Event</th>
                        <th class="px-4 py-3">Date</th>
                        <th class="px-4 py-3">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-sand">
                    @forelse ($registrations as $registration)
                        <tr>
                            <td class="px-4 py-3 font-semibold text-pine">{{ $registration->full_name }}</td>
                            <td class="px-4 py-3">{{ $registration->email }}</td>
                            <td class="px-4 py-3">{{ $registration->phone }}</td>
                            <td class="px-4 py-3">{{ $registration->event_title }}</td>
                            <td class="px-4 py-3">{{ $registration->created_at->format('M j, Y') }}</td>
                            <td class="px-4 py-3">
                                <a href="{{ route('admin.event-registrations.show', $registration) }}" class="font-bold text-pine hover:text-ember">View Details</a>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-4 py-8 text-center text-slate/70">No event registrations yet.</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        <div class="border-t border-sand p-4">
            {{ $registrations->links() }}
        </div>
    </section>
@endsection
