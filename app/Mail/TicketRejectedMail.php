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

    public function __construct($resellername, $eventname, $eventdate, $ticketname)
    {
        $this->resellername = $resellername;
        $this->eventname = $eventname;
        $this->eventdate = $eventdate;
        $this->ticketname = $ticketname;
    }

    public function build()
    {
        return $this
            ->subject('Ticket Rejected')
            ->view('emails.TicketRejected');
    }
}
