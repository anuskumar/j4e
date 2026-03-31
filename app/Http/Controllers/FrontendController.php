<?php

namespace App\Http\Controllers;

use App\Models\ArtistModel;
use App\Models\CountryModel;
use App\Models\CustomerModel;
use App\Models\EventImages;
use App\Models\EventReviews;
use App\Models\Events;
use App\Models\EventTickets;
use App\Models\EventTiming;
use App\Models\OrderStatusUpdate;
use App\Models\ResellerModel;
use App\Models\TicketPurchase;
use App\Models\TicketsGenerated;
use App\Models\User;
use App\Models\VenueSeating;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Barryvdh\DomPDF\Facade\Pdf;


class FrontendController extends Controller
{
    //

    public function sell_tickets(){

        $auth = Auth::user();

        if($auth){

            if(Auth::user()->user_type == "reseller"){

                return redirect()->route('reseller.home')->with('success','Logged in Successfully');

            }else{

              return redirect('reseller/login')->with('info','You are not a Reseller..plz sign in as a reseller');

            }

        }else{

            return redirect('reseller/login')->with('error','Plz Login First');
        }

    }

    public function reseller_login(){

        return view('reseller.reseller_login');

    }


    public function login(Request $request){

        $validated = $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user && $user->user_type !== 'superadmin' && ! $user->hasVerifiedEmail()) {
            return redirect()->route('verification.notice')
                ->withErrors(['email' => "Your email doesn't verified"])
                ->with('unverified_email', $request->email);
        }

        $credentials = $request->only('email', 'password');
        if (Auth::attempt($credentials)) {

            if(Auth::user()->user_type=="reseller"){


                $reseller = ResellerModel::where('user_id',Auth::user()->id)->first();
                if($reseller->is_admin_approved==0){
                    info("2");
                    Session::flush();
                    Auth::logout();
                    return redirect('reseller/approval_error')
                    ->withErrors('Not Approved By Admin');

            }else{
                $userType = Auth::user()->user_type;
                if ($userType === 'superadmin') {
                    return redirect()->intended(route('admin.home'))->withSuccess('Signed in');
                } elseif ($userType === 'customer') {
                    return redirect()->intended(route('customer.home'))->withSuccess('Signed in');
                }
                return redirect()->intended(route('reseller.home'))->withSuccess('Signed in');
            }

            }else{
                $userType = Auth::user()->user_type;
                if ($userType === 'superadmin') {
                    return redirect()->intended(route('admin.home'))->withSuccess('Login to Admin Dashboard');
                } elseif ($userType === 'customer') {
                    return redirect()->intended(route('customer.home'))->withSuccess('Login to Customer Dashboard');
                }
                return redirect()->intended(route('reseller.home'))->withSuccess('Login to Reseller Dashboard');


            }

        }else{
            $errors = ['Email and Password are Incorrect'];
            return redirect()->back()->withErrors($errors);
        }

        return back()->withSuccess('Login details are not valid');

    }

    public function approval_error(){

        return view('reseller.approval_error');

    }
    public function reseller_registration(){

        $countries = CountryModel::get();
        return view('reseller.register',compact('countries'));

           }

           public function re_store(Request $request)
           {
               //

               // Required validation here
               $validated = $request->validate([
                   'name' => 'required',
                   'email' => 'required|email|unique:users',
                   'password'         => 'required',
                   'password_confirmation' => 'required|same:password',
                   'country_code'         => 'required',
                   'country'         => 'required',
                   'phone'         => 'required|unique:users',

               ]);



               $user = new User();
               $user->name = $request->name;
               $user->email = $request->email;
               $user->password = $request->password;

               $user->country = $request->country;
               $user->country_code = $request->country_code;
               $user->user_type = 'reseller';
               $user->password = Hash::make($request->password);
               $user->email_added_at = now();
               $user->is_active = 0;
               if($request->has('phone')){

                   $user->phone = $request->phone;
                  }


               $user->save();

               $customer = new ResellerModel();
               $customer->user_id = $user->id;
               $customer->save();

               $auth = Auth::user();
               if($auth){
                   $userType = Auth::user()->user_type;
                   if ($userType === 'superadmin') {
                       return redirect()->route('admin.home');
                   } elseif ($userType === 'customer') {
                       return redirect()->route('customer.home');
                   } elseif ($userType === 'reseller') {
                       return redirect()->route('reseller.home');
                   }
                   return redirect()->route('home');
               }else{
               $login = User::find($user->id);
               Auth::login($login);
               $user = User::find(Auth::user()->id);
               $user->last_login = new DateTime();
               $user->save();

               $userType = Auth::user()->user_type;
               if ($userType === 'superadmin') {
                   return redirect()->route('admin.home');
               } elseif ($userType === 'customer') {
                   return redirect()->route('customer.home');
               } elseif ($userType === 'reseller') {
                   return redirect()->route('reseller.home');
               }
               return redirect()->route('home');
               }


           }

           public function submit_ticket_selected(Request $request){

            $event_ticket_id = $request->event_ticket;
            $buy_count = $request->buy_count;

            $check_existing_purchase = TicketsGenerated::where('user_id',Auth::user()->id)->where('is_sold',0)
            ->where('under_purchase_hold',1)->first();
            if($check_existing_purchase){
            if($check_existing_purchase->event_tickets <> $event_ticket_id)
            {

                return redirect()->route('customer_ticket_billing_page',$check_existing_purchase->event_tickets);

            }
        }


            try {
                DB::beginTransaction();
                $check = TicketsGenerated::where('event_tickets',$event_ticket_id)->where('is_sold',0)->where('under_purchase_hold',0)->count();
                if($check>=$buy_count){

                   $data = TicketsGenerated::where('event_tickets', $event_ticket_id)->where('is_sold',0)->where('under_purchase_hold',0)
                    ->take($buy_count)
                    ->get();

                    foreach($data as $val){

                        $dat = TicketsGenerated::find($val->id);
                        $dat->user_id = Auth::user()->id;
                        $dat->under_purchase_hold = 1;
                        $dat->purchase_hold_time = date('Y-m-d H:i:s');
                        $dat->save();

                    }
                }

                DB::commit();
            } catch (\Exception $e) {

                DB::rollBack();
                return back()->with('danger',$e);

            }


                return redirect()->route('customer_ticket_billing_page',$event_ticket_id);
                // dd(Auth::user());



           }

           public function customer_ticket_billing_page($id){

            $timer = TicketsGenerated::where('event_tickets', $id)->where('user_id',Auth::user()->id)->where('is_sold',0)->first();

            if ($timer==null) {

                return redirect('ticket_purchase_expired');

            }
            $givenTime = Carbon::parse($timer->purchase_hold_time); // Replace with your given time
            $currentTime = Carbon::now();
            $minutesDifference = $givenTime->diffInMinutes($currentTime);
            // dd($minutesDifference);

              $data = EventTickets::
             leftjoin('ticket_type','ticket_type.id','event_tickets.ticket_type')
            ->leftjoin('event','event.id','event_tickets.event')
            ->leftjoin('venue','venue.id','event.venue')
            ->leftjoin('venue_seating','venue_seating.id','event_tickets.venue_seating')
            ->leftjoin('event_timings','event_timings.id','event_tickets.event_timing')
            ->leftjoin('ticket_status','ticket_status.id','event_tickets.ticket_status')
            ->leftjoin('location','location.id','venue.location')
            ->leftjoin('countries','countries.id','location.country')
            ->leftjoin('cities','cities.id','location.city')
            ->leftjoin('currency','currency.id','event_tickets.amount_currency')
            ->where('event_tickets.id',$id)
            ->select('event_tickets.*',
                'event_tickets.id as id',
                'event_tickets.web_price',
                'event_tickets.ticket_amount',
                'event_tickets.face_value',
                'venue.name as venue_name',
                'event_timings.event_date as event_date',
                'event_timings.from_time as event_time',
                'event.id as event_id',
                'event.event_name as event_name',
                'event.event_image as event_image',
                'currency.short_name as currency_name',
                'currency.short_name as short_name',
                'location.location_name as location_name',
                'countries.country_name as country_name',
                'cities.name as city_name')->first();
            // dd($data);

            $ticket_count = TicketsGenerated::where('event_tickets', $id)
            ->where('user_id',Auth::user()->id)->where('is_sold',0)->where('under_purchase_hold',1)->count();

            // dd($ticket_count);
            $customer = CustomerModel::where('user_id',Auth::user()->id)->first();

            $countries = CountryModel::get();

            return view('customer.ticket_billing',compact('minutesDifference','data','ticket_count','customer','countries','id'));

           }

           public function ticket_purchase_expired(){


            return view('customer.ticket_expired_hold');


           }

           public function release_my_tickets(){

            $event_ticket = TicketsGenerated::where('under_purchase_hold',1)->where('user_id',Auth::user()->id)->get();

            foreach ($event_ticket as $key) {


                    $dat = TicketsGenerated::find($key->id);
                    $dat->user_id = NULL;
                    $dat->under_purchase_hold = 0;
                    $dat->purchase_hold_time = NULL;
                    $dat->save();

            }

            return redirect('/');

           }

           public function booking_success($id){

            $data = EventTickets::
            leftjoin('ticket_type','ticket_type.id','event_tickets.ticket_type')
           ->leftjoin('event','event.id','event_tickets.event')
           ->leftjoin('venue','venue.id','event.venue')
           ->leftjoin('venue_seating','venue_seating.id','event_tickets.venue_seating')
           ->leftjoin('event_timings','event_timings.id','event_tickets.event_timing')
           ->leftjoin('ticket_status','ticket_status.id','event_tickets.ticket_status')
           ->leftjoin('location','location.id','venue.location')
           ->leftjoin('countries','countries.id','location.country')
           ->leftjoin('cities','cities.id','location.city')
           ->leftjoin('currency','currency.id','event_tickets.amount_currency')
           ->where('event_tickets.id',$id)
           ->select('*','event_tickets.id as id','venue.name as venue_name','event_timings.event_date as event_date',
           'event_timings.from_time as event_time','event.id as event_id','currency.short_name as currency_name')->first();

            return view('booking-success',compact('data','id'));

           }


           public function booking_failed(){

            return view('booking-failed');

           }


           public function view_invoice($id){

            $settings = \App\Models\CompanySettings::first();

            $data = TicketPurchase::where('ticket_purchase.id',$id)
            ->leftjoin('countries','countries.id','shipping_country')
            ->leftjoin('event','event.id','ticket_purchase.event_id')
           ->leftjoin('currency','currency.id','ticket_purchase.payment_currency')


            ->select('*','ticket_purchase.id as id','currency.name as currency_name')->first();

            $count = TicketsGenerated::where('purchase_id',$data->id)->count();
            $ticket = TicketsGenerated::where('purchase_id',$data->id)->first();

            return view('customer.view_invoice',compact('settings','data','count','ticket'));

           }

           public function show_details_show($id)
           {

            $settings = \App\Models\CompanySettings::first();

            $event_datas = Events::leftjoin('venue','venue.id','event.venue')
                                ->leftjoin('location','location.id','venue.location')
                                ->leftjoin('countries','countries.id','location.country')
                                ->leftjoin('cities','cities.id','location.city')
                                ->leftjoin('event_tags','event_tags.id','event.event_tag')


                                ->where('event.id',$id)
                                ->select('*','event.id as id','venue.name as venue_name',
                                'event.id as event_id','venue.image as venue_image')->first();

            // $event_tickets = TicketsGenerated::where()

            $event_images = EventImages::where('event',$id)->get();

            $event_reviews = EventReviews::where('event_id',$id)->get();
            $event_reviews_stars = EventReviews::where('event_id',$id)->sum('number_of_stars');

            $artist_data = [];

            if ($event_datas && !empty($event_datas->artists)) {
                $artistIds = json_decode($event_datas->artists, true);

                if (is_array($artistIds)) {
                    foreach ($artistIds as $artistId) {
                        $dat = ArtistModel::find($artistId);
                        if ($dat) {
                            $artist_data[] = $dat;
                        }
                    }
                }
            }
            
            $event_timings = EventTiming::where('event',$id)->where('is_active',1)->groupBy('event_date')->get();
            $event_timing = EventTiming::where('event',$id)->where('is_active',1)->groupBy('event_date')->first();
            
            // Get all unique seating types (zones) from tickets that have availability
            $available_zones = [];
            foreach ($event_timings as $timing_date) {
                $event_timing_list = EventTiming::get_events_with_date($timing_date->event, $timing_date->event_date);
                if ($event_timing_list) {
                    foreach ($event_timing_list as $event_time) {
                        $event_ticket_list = EventTiming::get_ticket_list($timing_date->event, $timing_date->id);
                        foreach ($event_ticket_list as $ticket) {
                            $ticket_availability = EventTiming::get_available_tickets($ticket->id);
                            if ($ticket_availability > 0 && !empty($ticket->seating_type_name)) {
                                // Add zone if not already in array
                                if (!in_array($ticket->seating_type_name, $available_zones)) {
                                    $available_zones[] = $ticket->seating_type_name;
                                }
                            }
                        }
                    }
                }
            }
            
            // Sort zones alphabetically
            sort($available_zones);
            
            // Also get venue seating for this specific venue (as fallback/backup)
            $venue_seating = [];
            if ($event_datas && $event_datas->venue) {
                $venue_seating = VenueSeating::where('venue', $event_datas->venue)->get();
            }

            return view('customer.show_details_show',compact('settings','id',
            'event_datas','event_images','event_reviews','artist_data','event_reviews_stars','event_timing','event_timings','venue_seating','available_zones'));

           }




           public function filterTickets(Request $request)
            {
                // info($request->all());
                $quantity = $request->input('quantity');
                $event_id = $request->input('event_id'); // Pass this if needed to identify the event

                $tickets = EventTiming::where('event_id', $event_id)
                    ->where('availability', '>=', $quantity)
                    ->get();
                // info($tickets);

                return response()->json(['tickets' => $tickets]);
            }
            public function getSeatingTypes($eventId)
{
    // Fetch seating types based on the event ID
    $seatingTypes = VenueSeating::where('event_id', $eventId)->get();

    return response()->json([
        'seating_types' => $seatingTypes,
    ]);
}

           public function show_booking_details_show($id){


            $settings = \App\Models\CompanySettings::first();

            $data = TicketPurchase::where('ticket_purchase.id',$id)
            ->leftjoin('countries','countries.id','shipping_country')
            ->leftjoin('event','event.id','ticket_purchase.event_id')
           ->leftjoin('currency','currency.id','ticket_purchase.payment_currency')
           ->leftjoin('purchase_status','purchase_status.id','ticket_purchase.purchase_status')
            ->select('*','ticket_purchase.id as id','currency.name as currency_name')->first();

            $data_list = TicketsGenerated::where('event_ticket_tickets.purchase_id',$id)
           ->leftjoin('ticket_purchase','ticket_purchase.id','event_ticket_tickets.purchase_id')
        //    ->leftjoin('event_ticket_tickets','event_ticket_tickets.id','ticket_purchase.event_ticket_id')
            ->leftjoin('countries','countries.id','shipping_country')
            ->leftjoin('event','event.id','ticket_purchase.event_id')
           ->leftjoin('currency','currency.id','ticket_purchase.payment_currency')
           ->leftjoin('event_timings','event_timings.id','event_ticket_tickets.event_timing')
           ->leftjoin('venue_seating','venue_seating.id','event_ticket_tickets.event_seating')
            ->select('*','event_ticket_tickets.id as id','currency.name as currency_name')->get();


            $count = TicketsGenerated::where('purchase_id',$data->id)->count();
            $ticket = TicketsGenerated::where('purchase_id',$data->id)->first();

            $log = OrderStatusUpdate::where('order_status_log.purchase_id',$id)
            ->leftjoin('purchase_status','purchase_status.id','order_status_log.status_id')
            ->leftjoin('users','users.id','order_status_log.created_by')
            ->select('*','order_status_log.id as id')
            ->get();

            return view('customer.view_booked_data',compact('settings','data','count','ticket','data_list','log'));

           }

           public function downloadInvoicePdf($id){
            $settings = \App\Models\CompanySettings::first();

            $data = TicketPurchase::where('ticket_purchase.id',$id)
            ->leftjoin('countries','countries.id','shipping_country')
            ->leftjoin('event','event.id','ticket_purchase.event_id')
           ->leftjoin('currency','currency.id','ticket_purchase.payment_currency')
           ->leftjoin('purchase_status','purchase_status.id','ticket_purchase.purchase_status')
            ->select('*','ticket_purchase.id as id','currency.name as currency_name')->first();

            $data_list = TicketsGenerated::where('event_ticket_tickets.purchase_id',$id)
           ->leftjoin('ticket_purchase','ticket_purchase.id','event_ticket_tickets.purchase_id')
            ->leftjoin('countries','countries.id','shipping_country')
            ->leftjoin('event','event.id','ticket_purchase.event_id')
           ->leftjoin('currency','currency.id','ticket_purchase.payment_currency')
           ->leftjoin('event_timings','event_timings.id','event_ticket_tickets.event_timing')
           ->leftjoin('venue_seating','venue_seating.id','event_ticket_tickets.event_seating')
            ->select('*','event_ticket_tickets.id as id','currency.name as currency_name')->get();

            $count = TicketsGenerated::where('purchase_id',$data->id)->count();
            $ticket = TicketsGenerated::where('purchase_id',$data->id)->first();

            $pdf = Pdf::loadView('customer.invoice_pdf', compact('settings','data','count','ticket','data_list'));
            $pdf->setPaper('a4', 'portrait');
            
            return $pdf->download('invoice-' . str_pad($data->id, 6, '0', STR_PAD_LEFT) . '.pdf');
           }

    public function customer_profile_settings(){

                 return view('customer.profile');
           }

           public function updatefacevalueticket(Request $request)
           {
                // info($request->web_price);
                $update = EventTickets::find($request->event_ticket_id);

                if ($update) {
                    $update->web_price = $request->web_price;
                    $update->save();

                    return response()->json(['success' => true, 'message' => 'web price updated successfully']);
                } else {
                    return response()->json(['success' => false, 'message' => 'Record not found.']);
                }
           }



public function upload_ticket(Request $request,$id){
    $ticket = EventTickets::find($id);

    if (!$ticket) {
        return redirect()->back()->with('error', 'Ticket not found.');
    }

    if ($request->hasFile('ticket_file')) {
        $imageName = rand() . '.' . $request->ticket_file->extension();

        $request->ticket_file->move(storage_path('uploads/ticket_images'), $imageName);

        $ticket->update(['ticket_upload' => $imageName]);

        return redirect()->back()->with('success', 'Image updated successfully.');
    } else {
        return redirect()->back()->with('error', 'No file uploaded.');
    }
}

public function update_customer_profile(Request $request){

    // dd($request->all());

    $profile = User::find(Auth::user()->id);

    if($request->has('name')){
        $profile->name = $request->name;
    }
    if($request->has('date_of_birth')){
        $profile->date_or_birth = date('Y-m-d',strtotime($request->date_of_birth));
    }
    if($request->has('phone')){
        $profile->phone = $request->phone;
    }
    if($request->has('address')){
        $profile->address = $request->address;
    }

    if ($request->hasFile('profile')) {
        $imageName = rand() . '.' . $request->profile->extension();

        $request->profile->move(storage_path('uploads/images'), $imageName);

        $profile->profile =  $imageName;
    }
    $profile->save();

    return redirect()->back();
}

}
