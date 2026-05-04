@extends('layouts.admin', ['title' => 'Program Registration Details'])

@section('content')
    <a href="{{ route('admin.program-registrations.index') }}" class="text-sm font-bold text-pine hover:text-sage">Back to program registrations</a>
    <section class="mt-6 rounded-lg border border-sand bg-white p-6">
        <h1 class="text-3xl">{{ $registration->full_name }}</h1>
        <div class="mt-5 grid gap-4 md:grid-cols-2">
            <p><span class="font-bold text-pine">Program:</span> {{ $registration->program_title }}</p>
            <p><span class="font-bold text-pine">Cohort:</span> {{ $registration->cohort ?: 'Not selected' }}</p>
            <p><span class="font-bold text-pine">Email:</span> {{ $registration->email }}</p>
            <p><span class="font-bold text-pine">Phone:</span> {{ $registration->phone }}</p>
            <p><span class="font-bold text-pine">Organization:</span> {{ $registration->organization ?: 'Not provided' }}</p>
            <p><span class="font-bold text-pine">Submitted:</span> {{ $registration->created_at->format('M d, Y g:i A') }}</p>
        </div>

        @if (!empty($registration->responses))
            <div class="mt-6 border-t border-sand pt-5">
                <h2 class="text-2xl">Responses</h2>
                <div class="mt-4 grid gap-4">
                    @foreach ($registration->responses as $key => $response)
                        <div class="rounded-lg bg-mist p-4">
                            <p class="font-bold text-pine">{{ str($key)->replace('_', ' ')->title() }}</p>
                            <p class="mt-2 text-slate/80">{{ $response }}</p>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    </section>
@endsection
