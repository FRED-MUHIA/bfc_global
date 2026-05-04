<?php

namespace App\Mail;

use App\Models\ProgramRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ProgramRegistrationSubmitted extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public ProgramRegistration $registration,
        public bool $adminCopy = true,
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->adminCopy
                ? 'New Program Registration: ' . $this->registration->program_title
                : 'Program Registration Received: ' . $this->registration->program_title,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.program-registration-submitted',
        );
    }
}
