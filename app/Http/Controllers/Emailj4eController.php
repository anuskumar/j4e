<?php

namespace App\Http\Controllers;

use App\Mail\J4eMail;
use App\Mail\paidpaymentMail;
use App\Mail\ticketexpiredMail;
use App\Mail\TicketApprovedMail;
use App\Mail\ticketdeliveredMail;
use App\Mail\ticketsoldMail;
use App\Mail\uploadticketMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Carbon\Carbon;
use App\Models\EventTickets;
use App\Models\User;

class Emailj4eController extends Controller
{
    public function ticketapprovedmail($maildata)
    { 
        try {
        // $email = $maildata['email','resellername','eventname','eventdate','numberoftickets','totalamount'];
        $email = $maildata['email'];
        $resellername = $maildata['resellername'];
        $eventname = $maildata['eventname'];
        $eventdate = $maildata['eventdate'];
        $numberoftickets = $maildata['numberoftickets'];
        $totalamount = $maildata['totalamount'];
        info($maildata);
         Mail::to($email)->send(new TicketApprovedMail($resellername, $eventname, $eventdate,$numberoftickets,$totalamount));
       
        return "Email sent successfully!";
        } catch (\Exception $e) {
            // Log the error but don't throw exception
            \Log::error('Failed to send ticket approval email: ' . $e->getMessage(), [
                'email' => $maildata['email'] ?? 'unknown',
                'error' => $e->getMessage()
            ]);
            return "Email sending failed: " . $e->getMessage();
        }
    }
    
   
    public function sendEmail()
{
    Mail::to('sheebarobert18@gmail.com')->send(new J4eMail());
    return "Email sent successfully!";
}
public function ticketsoldmail($maildata){
    $email = $maildata['email'];
        $resellername = $maildata['resellername'];
        $eventname = $maildata['eventname'];
        $eventdate = $maildata['eventdate'];
        $ticket_name = $maildata['ticket_name'];
        $ticket_count_data = $maildata['ticket_count_data'];
        $price = $maildata['price'];
        
    
    
    Mail::to( $email)->send(new ticketsoldMail($resellername, $eventname, $eventdate,$ticket_name,$ticket_count_data,$price));
    return "Email sent successfully!";
}

public function ticketexpiredmail(){
    
    $today = Carbon::now();
    $booking_expiry_date_times = EventTickets::pluck('booking_expiry_date_time');
    
    foreach($booking_expiry_date_times as $booking_expiry_date_time) {
        $booking_expiry_date = Carbon::parse($booking_expiry_date_time);
        
        $next_day = $booking_expiry_date->copy()->addDay();
        
        if ($next_day->isSameDay($today)) {
            $tickets = EventTickets::whereDate('booking_expiry_date_time', $booking_expiry_date->toDateString())->get();
            
            foreach($tickets as $t)
            {
                $userdata = User::where('id',$t->created_by)->first();
                $resellername = $userdata->name;
                $ticket_name = $t->ticket_name;
                
                Mail::to($userdata->email)->send(new ticketexpiredMail($resellername,$ticket_name));
            }
            
            return "Email sent successfully!";
        }
    }
    
    return "Tomorrow's date does not match the booking expiry date.";
}


public function ticketuploadmail(){
    Mail::to('sheebarobert18@gmail.com')->send(new uploadticketMail());
    return "Email sent successfully!";
}
public function ticketdeliveredmail(){
    Mail::to('sheebarobert18@gmail.com')->send(new ticketdeliveredMail());
    return "Email sent successfully!";
}

public function ticketpaidmail(){
    Mail::to('sheebarobert18@gmail.com')->send(new paidpaymentMail());
    return "Email sent successfully!";
}


}

