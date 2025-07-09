<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ticketexpiredMail extends Mailable
{
    use Queueable, SerializesModels;
    public $resellername;
    public $ticket_name;

    /**
     * Create a new message instance.
     */
    public function __construct($resellername, $ticket_name)
    {
        $this->resellername = $resellername;
        $this->ticket_name = $ticket_name;
    }
    public function build()
    {
        // return $this->view('view.name');
        return $this
            ->subject('Subject of the email')
            ->view('emails.ticketexpired');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticketexpired Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticketexpired',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
