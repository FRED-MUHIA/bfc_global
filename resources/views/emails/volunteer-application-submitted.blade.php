<h2>New Involvement Form Submission</h2>

<p><strong>Selected Option:</strong> {{ $application->role ?: 'Volunteer' }}</p>
<p><strong>Name:</strong> {{ $application->full_name }}</p>
<p><strong>Email:</strong> {{ $application->email }}</p>
<p><strong>Phone:</strong> {{ $application->phone }}</p>
<p><strong>Availability:</strong> {{ $application->availability ?: 'Not provided' }}</p>

<p><strong>Message / Interests:</strong></p>
<p>{{ $application->interests }}</p>
