@extends('layouts.admin', ['title' => 'Registration Details'])

@section('content')
    <a href="{{ route('admin.event-registrations.index') }}" class="text-sm font-bold text-pine hover:text-sage">Back to registrations</a>
    <h1 class="mt-2 text-4xl">{{ $registration->full_name }}</h1>
    <p class="mt-2 text-slate/75">{{ $registration->event_title }}</p>

    <section class="mt-7 grid gap-6 lg:grid-cols-2">
        <div class="rounded-lg border border-sand bg-white p-5">
            <h2 class="text-2xl">Contact Details</h2>
            <div class="mt-4 grid gap-3 text-sm">
                <p><span class="font-bold text-pine">Email:</span> {{ $registration->email }}</p>
                <p><span class="font-bold text-pine">Phone:</span> {{ $registration->phone }}</p>
                <p><span class="font-bold text-pine">Organization:</span> {{ $registration->organization ?: 'Not provided' }}</p>
                <p><span class="font-bold text-pine">Submitted:</span> {{ $registration->created_at->format('M j, Y g:i A') }}</p>
            </div>
        </div>

        <div class="rounded-lg border border-sand bg-white p-5">
            <h2 class="text-2xl">Responses</h2>
            <div class="mt-4 grid gap-4 text-sm">
                @forelse (($registration->responses ?? []) as $key => $response)
                    <div>
                        <p class="font-bold text-pine">{{ str($key)->replace('_', ' ')->title() }}</p>
                        <p class="mt-1 whitespace-pre-line text-slate/80">{{ $response }}</p>
                    </div>
                @empty
                    <p class="text-slate/70">No custom responses.</p>
                @endforelse
            </div>
        </div>
    </section>
@endsection
