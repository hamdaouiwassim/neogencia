<?php

namespace App\Mail;

use App\Models\SignupInvitation;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SignupInvitationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public SignupInvitation $invitation
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: __('Your Neogencia invitation link'),
        );
    }

    public function content(): Content
    {
        return new Content(
            html: 'emails.signup-invitation',
            text: 'emails.signup-invitation-text',
        );
    }
}
