<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CustomerTicketPurchaseMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public string $customerName,
        public string $eventName,
        public string $eventDate,
        public string $ticketName,
        public int $ticketCount,
        public string $currency,
        public float $totalAmount,
        public int $purchaseId
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Your Ticket Purchase Confirmation',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.customer_ticket_purchase',
        );
    }

    public function attachments(): array
    {
        return [];
    }
}

