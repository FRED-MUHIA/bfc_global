<?php

namespace App\Mail;

use App\Models\EventRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class EventRegistrationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public EventRegistration $registration,
        public bool $adminCopy = true,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->adminCopy
                ? 'New Event Registration: ' . $this->registration->event_title
                : 'Event Registration Received: ' . $this->registration->event_title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.event-registration-submitted',
        );
    }
}
