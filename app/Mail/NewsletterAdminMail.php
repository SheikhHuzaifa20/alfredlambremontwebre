<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterAdminMail extends Mailable
{
    use Queueable, SerializesModels;

    public $subscriberEmail;

    public function __construct(string $subscriberEmail)
    {
        $this->subscriberEmail = $subscriberEmail;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Newsletter Subscriber',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.newsletter-admin',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}
