<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ticketsoldMail extends Mailable
{
    use Queueable, SerializesModels;
    public $resellername;
    public $eventname;
    public $eventdate;
    public $ticket_name;
    public $ticket_count;
    public $price;

    /**
     * Create a new message instance.
     */
    public function __construct($resellername, $eventname, $eventdate, $ticket_name, $ticket_count_data,$price)
    {
        $this->resellername = $resellername;
        $this->eventname = $eventname;
        $this->eventdate = $eventdate;
        $this->ticket_name = $ticket_name;
        $this->ticket_count_data = $ticket_count_data;
        $this->price = $price;
    }
    public function build()
    {
        // return $this->view('view.name');
        return $this
            ->subject('Subject of the email')
            ->view('emails.ticketsold');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticketsold Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.ticketsold',
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
