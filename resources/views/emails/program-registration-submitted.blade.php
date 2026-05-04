<h2>{{ $adminCopy ? 'New Program Registration' : 'Program Registration Received' }}</h2>

<p><strong>Program:</strong> {{ $registration->program_title }}</p>
<p><strong>Cohort / Intake:</strong> {{ $registration->cohort ?: 'Not selected' }}</p>
<p><strong>Name:</strong> {{ $registration->full_name }}</p>
<p><strong>Email:</strong> {{ $registration->email }}</p>
<p><strong>Phone:</strong> {{ $registration->phone }}</p>
<p><strong>Organization:</strong> {{ $registration->organization ?: 'Not provided' }}</p>

@if (!empty($registration->responses))
    <h3>Responses</h3>
    @foreach ($registration->responses as $key => $response)
        <p><strong>{{ str($key)->replace('_', ' ')->title() }}:</strong> {{ $response }}</p>
    @endforeach
@endif

@unless ($adminCopy)
    <p>Thank you for registering. Our team will follow up with the next steps.</p>
@endunless
