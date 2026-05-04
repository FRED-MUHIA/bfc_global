<h2>{{ $adminCopy ? 'New Event Registration' : 'Registration Received' }}</h2>

<p><strong>Event:</strong> {{ $registration->event_title }}</p>
<p><strong>Name:</strong> {{ $registration->full_name }}</p>
<p><strong>Email:</strong> {{ $registration->email }}</p>
<p><strong>Phone:</strong> {{ $registration->phone }}</p>
<p><strong>Organization:</strong> {{ $registration->organization ?: 'Not provided' }}</p>

@if ($registration->responses)
    <h3>Responses</h3>
    <ul>
        @foreach ($registration->responses as $key => $response)
            <li><strong>{{ str($key)->replace('_', ' ')->title() }}:</strong> {{ $response }}</li>
        @endforeach
    </ul>
@endif

@unless ($adminCopy)
    <p>Thank you for registering your interest. Our team will follow up with the next details.</p>
@endunless
