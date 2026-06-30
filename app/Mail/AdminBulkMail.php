<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AdminBulkMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * @param  array<int, array{path: string, name: string}>  $mailAttachments
     */
    public function __construct(
        public string $mailSubject,
        public string $mailBody,
        public string $recipientName,
        public array $mailAttachments = [],
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: $this->mailSubject,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.admin_bulk_mail',
        );
    }

    public function attachments(): array
    {
        return array_map(function (array $attachment) {
            return Attachment::fromPath($attachment['path'])
                ->as($attachment['name']);
        }, $this->mailAttachments);
    }
}
