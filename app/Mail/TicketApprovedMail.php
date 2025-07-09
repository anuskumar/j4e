<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TicketApprovedMail extends Mailable
{
    use Queueable, SerializesModels;
    public $resellername;
    public $eventname;
    public $eventdate;
    public $numberoftickets;
    public $totalamount;

    /**
     * Create a new message instance.
     */
    public function __construct($resellername, $eventname, $eventdate, $numberoftickets, $totalamount)
    {
        $this->resellername = $resellername;
        $this->eventname = $eventname;
        $this->eventdate = $eventdate;
        $this->numberoftickets = $numberoftickets;
        $this->totalamount = $totalamount;
    }


    public function build()
    {
        return $this
            ->subject('Ticket Approved Mail')
            ->view('emails.TicketApproved');
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Ticket Approved Mail',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.TicketApproved',
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
