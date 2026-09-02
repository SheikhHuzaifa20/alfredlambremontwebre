<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class NewsletterUserMail extends Mailable
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
            subject: 'Welcome to Alfred Lambremont Webre\'s Newsletter',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'email.newsletter-user',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}