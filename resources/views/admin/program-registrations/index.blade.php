@extends('layouts.admin', ['title' => 'Program Registrations'])

@section('content')
    <div class="mb-6 flex flex-wrap items-end justify-between gap-4">
        <div>
            <a href="{{ route('admin.dashboard') }}" class="text-sm font-bold text-pine hover:text-ember">Back to dashboard</a>
            <h1 class="mt-3 text-4xl">Program Registrations</h1>
            <p class="mt-2 text-slate/75">Review program intake and cohort registrations.</p>
        </div>
        <a href="{{ route('admin.program-registrations.export') }}" class="rounded-full bg-ember px-5 py-3 text-sm font-bold text-white hover:bg-ember/90">Export CSV</a>
    </div>

    <div class="overflow-hidden rounded-lg border border-sand bg-white">
        <table class="w-full min-w-[860px] text-left text-sm">
            <thead class="bg-mist text-pine">
                <tr>
                    <th class="px-4 py-3">Name</th>
                    <th class="px-4 py-3">Email</th>
                    <th class="px-4 py-3">Phone</th>
                    <th class="px-4 py-3">Program</th>
                    <th class="px-4 py-3">Cohort</th>
                    <th class="px-4 py-3">Date</th>
                    <th class="px-4 py-3">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-sand">
                @forelse ($registrations as $registration)
                    <tr>
                        <td class="px-4 py-3 font-bold text-pine">{{ $registration->full_name }}</td>
                        <td class="px-4 py-3">{{ $registration->email }}</td>
                        <td class="px-4 py-3">{{ $registration->phone }}</td>
                        <td class="px-4 py-3">{{ $registration->program_title }}</td>
                        <td class="px-4 py-3">{{ $registration->cohort ?: '-' }}</td>
                        <td class="px-4 py-3">{{ $registration->created_at->format('M d, Y') }}</td>
                        <td class="px-4 py-3">
                            <a href="{{ route('admin.program-registrations.show', $registration) }}" class="font-bold text-pine hover:text-ember">View Details</a>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" class="px-4 py-8 text-center text-slate/70">No program registrations yet.</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-6">{{ $registrations->links() }}</div>
@endsection
