<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TicketRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public $resellername;
    public $eventname;
    public $eventdate;
    public $ticketname;
    public $rejection_reason;

    public function __construct($resellername, $eventname, $eventdate, $ticketname, $rejection_reason = null)
    {
        $this->resellername = $resellername;
        $this->eventname = $eventname;
        $this->eventdate = $eventdate;
        $this->ticketname = $ticketname;
        $this->rejection_reason = $rejection_reason;
    }

    public function build()
    {
        return $this
            ->subject('Ticket Listing Rejected')
            ->view('emails.TicketRejected');
    }
}
