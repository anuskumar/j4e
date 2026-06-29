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
use App\Models\RestrictionModel;
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

            $request->validate([
                'event_ticket' => 'required|integer',
                'buy_count' => 'required|integer|min:1',
            ]);

            $event_ticket_id = (int) $request->event_ticket;
            $buy_count = (int) $request->buy_count;
            $validHoldStart = Carbon::now()->subMinutes(15);

            $check_existing_purchase = TicketsGenerated::where('user_id', Auth::user()->id)
                ->where('is_sold', 0)
                ->where('under_purchase_hold', 1)
                ->where('purchase_hold_time', '>=', $validHoldStart)
                ->where('event_tickets', $event_ticket_id)
                ->first();

            try {
                DB::beginTransaction();

                if ($check_existing_purchase) {
                    TicketsGenerated::where('event_tickets', $event_ticket_id)
                        ->where('user_id', Auth::id())
                        ->where('is_sold', 0)
                        ->where('under_purchase_hold', 1)
                        ->where('purchase_hold_time', '>=', $validHoldStart)
                        ->update([
                            'user_id' => null,
                            'under_purchase_hold' => 0,
                            'purchase_hold_time' => null,
                        ]);
                }

                $check = TicketsGenerated::where('event_tickets', $event_ticket_id)
                    ->where('is_sold', 0)
                    ->where('under_purchase_hold', 0)
                    ->count();

                if ($check >= $buy_count) {
                    $data = TicketsGenerated::where('event_tickets', $event_ticket_id)
                        ->where('is_sold', 0)
                        ->where('under_purchase_hold', 0)
                        ->orderBy('id')
                        ->take($buy_count)
                        ->lockForUpdate()
                        ->get();

                    foreach ($data as $val) {
                        $dat = TicketsGenerated::find($val->id);
                        $dat->user_id = Auth::user()->id;
                        $dat->under_purchase_hold = 1;
                        $dat->purchase_hold_time = date('Y-m-d H:i:s');
                        $dat->save();
                    }
                } else {
                    DB::rollBack();
                    return redirect()->back()->withErrors([
                        "Only {$check} ticket(s) are available right now. Please reduce quantity and try again.",
                    ]);
                }

                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                return back()->with('danger', $e);
            }

            return redirect()->route('customer_ticket_billing_page', $event_ticket_id);
           }

           /**
            * Adjust purchase holds for the billing page when the customer changes ticket quantity
            * in the calculator (adds or releases holds to match the requested count).
            */
           public function syncTicketHoldCount(Request $request)
           {
               $validated = $request->validate([
                   'event_ticket_id' => 'required|integer|exists:event_tickets,id',
                   'ticket_count' => 'required|integer|min:1|max:5000',
               ]);

               $eventTicketId = (int) $validated['event_ticket_id'];
               $validHoldStart = Carbon::now()->subMinutes(15);
               $userId = Auth::id();

               try {
                   DB::transaction(function () use ($eventTicketId, $userId, $validHoldStart, $validated) {
                       $myHeld = TicketsGenerated::where('event_tickets', $eventTicketId)
                           ->where('user_id', $userId)
                           ->where('is_sold', 0)
                           ->where('under_purchase_hold', 1)
                           ->where('purchase_hold_time', '>=', $validHoldStart)
                           ->orderBy('id')
                           ->lockForUpdate()
                           ->get();

                       $currentHeld = $myHeld->count();

                       if ($currentHeld < 1) {
                           throw new \RuntimeException('hold_expired');
                       }

                       $freePoolCount = (int) TicketsGenerated::where('event_tickets', $eventTicketId)
                           ->where('is_sold', 0)
                           ->where('under_purchase_hold', 0)
                           ->count();

                       $maxAllowed = $currentHeld + $freePoolCount;
                       $desired = min(max(1, (int) $validated['ticket_count']), $maxAllowed);

                       if ($desired > $currentHeld) {
                           $need = $desired - $currentHeld;
                           $toAdd = TicketsGenerated::where('event_tickets', $eventTicketId)
                               ->where('is_sold', 0)
                               ->where('under_purchase_hold', 0)
                               ->orderBy('id')
                               ->take($need)
                               ->lockForUpdate()
                               ->get();

                           foreach ($toAdd as $row) {
                               $row->user_id = $userId;
                               $row->under_purchase_hold = 1;
                               $row->purchase_hold_time = now();
                               $row->save();
                           }
                       } elseif ($desired < $currentHeld) {
                           $releaseCount = $currentHeld - $desired;
                           $toRelease = TicketsGenerated::where('event_tickets', $eventTicketId)
                               ->where('user_id', $userId)
                               ->where('is_sold', 0)
                               ->where('under_purchase_hold', 1)
                               ->where('purchase_hold_time', '>=', $validHoldStart)
                               ->orderByDesc('id')
                               ->take($releaseCount)
                               ->lockForUpdate()
                               ->get();

                           foreach ($toRelease as $row) {
                               $row->user_id = null;
                               $row->under_purchase_hold = 0;
                               $row->purchase_hold_time = null;
                               $row->save();
                           }
                       }
                   });
               } catch (\RuntimeException $e) {
                   if ($e->getMessage() === 'hold_expired') {
                       return response()->json([
                           'ok' => false,
                           'code' => 'hold_expired',
                           'message' => 'Your ticket hold has expired. Please select tickets again.',
                           'redirect' => url('ticket_purchase_expired'),
                       ], 422);
                   }
                   throw $e;
               } catch (\Exception $e) {
                   return response()->json([
                       'ok' => false,
                       'message' => 'Unable to update ticket hold. Please try again.',
                   ], 500);
               }

               $heldCount = (int) TicketsGenerated::where('event_tickets', $eventTicketId)
                   ->where('user_id', $userId)
                   ->where('is_sold', 0)
                   ->where('under_purchase_hold', 1)
                   ->where('purchase_hold_time', '>=', $validHoldStart)
                   ->count();

               $availableTicketCount = (int) TicketsGenerated::where('event_tickets', $eventTicketId)
                   ->where('is_sold', 0)
                   ->where(function ($query) use ($validHoldStart, $userId) {
                       $query->where('under_purchase_hold', 0)
                           ->orWhere(function ($holdQuery) use ($validHoldStart, $userId) {
                               $holdQuery->where('under_purchase_hold', 1)
                                   ->where('user_id', $userId)
                                   ->where('purchase_hold_time', '>=', $validHoldStart);
                           });
                   })
                   ->count();

               $maxQty = max(1, $availableTicketCount);

               return response()->json([
                   'ok' => true,
                   'ticket_count' => $heldCount,
                   'max_qty' => $maxQty,
                   'available_ticket_count' => $availableTicketCount,
               ]);
           }

           public function customer_ticket_billing_page($id){

            $validHoldStart = Carbon::now()->subMinutes(15);
            $timer = TicketsGenerated::where('event_tickets', $id)
                ->where('user_id', Auth::user()->id)
                ->where('is_sold', 0)
                ->where('under_purchase_hold', 1)
                ->where('purchase_hold_time', '>=', $validHoldStart)
                ->orderByDesc('purchase_hold_time')
                ->first();

            if ($timer==null) {

                return redirect('ticket_purchase_expired');

            }
            $givenTime = Carbon::parse($timer->purchase_hold_time);
            $currentTime = Carbon::now();
            $expiresAt = $givenTime->copy()->addMinutes(15);
            $remainingSeconds = max(0, $expiresAt->timestamp - $currentTime->timestamp);
            $sessionDurationSeconds = 15 * 60;
            $minutesDifference = $givenTime->diffInMinutes($currentTime);

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
            ->leftjoin('split_types', 'split_types.id', 'event_tickets.split_type')
            ->where('event_tickets.id',$id)
            ->select('event_tickets.*',
                'event_tickets.id as id',
                'event_tickets.web_price',
                'event_tickets.ticket_amount',
                'event_tickets.face_value',
                'venue.name as venue_name',
                'venue_seating.seating_type_name',
                'ticket_type.ticket_type_name',
                'split_types.split_name as split_type_name',
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

            $restrictionIds = $data->ticket_restrictions ? json_decode($data->ticket_restrictions, true) : [];
            $restrictionLabels = is_array($restrictionIds) && $restrictionIds
                ? RestrictionModel::whereIn('id', $restrictionIds)->pluck('restrictions')->all()
                : [];

            $ticket_count = TicketsGenerated::where('event_tickets', $id)
                ->where('user_id', Auth::user()->id)
                ->where('is_sold', 0)
                ->where('under_purchase_hold', 1)
                ->where('purchase_hold_time', '>=', $validHoldStart)
                ->count();

            $available_ticket_count = TicketsGenerated::where('event_tickets', $id)
                ->where('is_sold', 0)
                ->where(function ($query) use ($validHoldStart) {
                    $query->where('under_purchase_hold', 0)
                        ->orWhere(function ($holdQuery) use ($validHoldStart) {
                            $holdQuery->where('under_purchase_hold', 1)
                                ->where('user_id', Auth::id())
                                ->where('purchase_hold_time', '>=', $validHoldStart);
                        });
                })
                ->count();

            // dd($ticket_count);
            $customer = CustomerModel::where('user_id',Auth::user()->id)->first();

            $countries = CountryModel::get();

            return view('customer.ticket_billing', compact(
                'minutesDifference',
                'remainingSeconds',
                'sessionDurationSeconds',
                'data',
                'ticket_count',
                'available_ticket_count',
                'customer',
                'countries',
                'id',
                'restrictionLabels'
            ));

           }

           public function ticket_purchase_expired(){


            return view('customer.ticket_expired_hold');


           }

           private function buildUserCartItems(?int $userId = null): array
           {
               $userId = $userId ?? Auth::id();
               if (!$userId) {
                   return [];
               }

               $validHoldStart = Carbon::now()->subMinutes(15);

               $grouped = TicketsGenerated::where('user_id', $userId)
                   ->where('is_sold', 0)
                   ->where('under_purchase_hold', 1)
                   ->where('purchase_hold_time', '>=', $validHoldStart)
                   ->orderByDesc('purchase_hold_time')
                   ->get()
                   ->groupBy('event_tickets');

               if ($grouped->isEmpty()) {
                   return [];
               }

               $items = [];
               foreach ($grouped as $eventTicketId => $tickets) {
                   $data = EventTickets::leftjoin('ticket_type', 'ticket_type.id', 'event_tickets.ticket_type')
                       ->leftjoin('event', 'event.id', 'event_tickets.event')
                       ->leftjoin('venue', 'venue.id', 'event.venue')
                       ->leftjoin('venue_seating', 'venue_seating.id', 'event_tickets.venue_seating')
                       ->leftjoin('event_timings', 'event_timings.id', 'event_tickets.event_timing')
                       ->leftjoin('location', 'location.id', 'venue.location')
                       ->leftjoin('countries', 'countries.id', 'location.country')
                       ->leftjoin('currency', 'currency.id', 'event_tickets.amount_currency')
                       ->where('event_tickets.id', $eventTicketId)
                       ->select(
                           'event_tickets.*',
                           'event_tickets.id as id',
                           'event.event_name',
                           'event.event_image',
                           'venue.name as venue_name',
                           'venue_seating.seating_type_name',
                           'ticket_type.ticket_type_name',
                           'event_timings.event_date',
                           'event_timings.from_time as event_time',
                           'location.location_name',
                           'countries.country_name',
                           'currency.short_name as short_name'
                       )
                       ->first();

                   if (!$data) {
                       continue;
                   }

                   $quantity = $tickets->count();
                   $unitPrice = (float) ($data->ticket_amount ?? $data->web_price ?? 0);

                   $items[] = [
                       'event_ticket_id' => (int) $eventTicketId,
                       'data' => $data,
                       'quantity' => $quantity,
                       'unit_price' => $unitPrice,
                       'total' => $unitPrice * $quantity,
                       'hold_time' => $tickets->max('purchase_hold_time'),
                   ];
               }

               usort($items, function ($a, $b) {
                   return strcmp($b['hold_time'] ?? '', $a['hold_time'] ?? '');
               });

               return $items;
           }

           public function customerTicketCart()
           {
               $cartItems = $this->buildUserCartItems();

               if (empty($cartItems)) {
                   return redirect('/')->with('info', 'You have no reserved tickets in your cart.');
               }

               $cartTotal = array_sum(array_map(fn ($item) => $item['total'], $cartItems));
               $totalTickets = array_sum(array_map(fn ($item) => $item['quantity'], $cartItems));

               return view('customer.ticket_cart', compact('cartItems', 'cartTotal', 'totalTickets'));
           }

           public function release_my_tickets(){

            TicketsGenerated::where('under_purchase_hold', 1)
                ->where('user_id', Auth::id())
                ->update([
                    'user_id' => null,
                    'under_purchase_hold' => 0,
                    'purchase_hold_time' => null,
                ]);

            return redirect('/')->with('success', 'All reserved tickets have been released.');

           }

           public function releaseTicketListing($id)
           {
               $eventTicketId = (int) $id;
               $validHoldStart = Carbon::now()->subMinutes(15);

               $released = TicketsGenerated::where('event_tickets', $eventTicketId)
                   ->where('user_id', Auth::id())
                   ->where('is_sold', 0)
                   ->where('under_purchase_hold', 1)
                   ->where('purchase_hold_time', '>=', $validHoldStart)
                   ->update([
                       'user_id' => null,
                       'under_purchase_hold' => 0,
                       'purchase_hold_time' => null,
                   ]);

               if ($released < 1) {
                   return redirect()->route('customer_ticket_cart')->with('info', 'No active holds found for this listing.');
               }

               $remaining = $this->buildUserCartItems();
               if (empty($remaining)) {
                   return redirect('/')->with('success', 'Listing released. Your cart is now empty.');
               }

               return redirect()->route('customer_ticket_cart')->with('success', 'Tickets for this listing have been released.');
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

           public function booking_confirmed($id)
           {
               $purchase = TicketPurchase::where('ticket_purchase.id', $id)
                   ->where('ticket_purchase.user_id', Auth::id())
                   ->leftjoin('event', 'event.id', 'ticket_purchase.event_id')
                   ->leftjoin('event_tickets', 'event_tickets.id', 'ticket_purchase.event_ticket_id')
                   ->leftjoin('event_timings', 'event_timings.id', 'event_tickets.event_timing')
                   ->leftjoin('venue', 'venue.id', 'event.venue')
                   ->leftjoin('currency', 'currency.id', 'ticket_purchase.payment_currency')
                   ->select(
                       'ticket_purchase.*',
                       'ticket_purchase.id as id',
                       'event.event_name',
                       'event_tickets.ticket_name',
                       'event_timings.event_date',
                       'event_timings.from_time as event_time',
                       'venue.name as venue_name',
                       'currency.short_name as currency_short_name',
                       'currency.name as currency_name'
                   )
                   ->firstOrFail();

               return view('customer.booking_confirmed', compact('purchase'));
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
                        $event_ticket_list = EventTiming::get_ticket_list($timing_date->event, $event_time->id);
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

            $allTickets = [];
            foreach ($event_timings as $timing_date) {
                $event_timing_list = EventTiming::get_events_with_date($timing_date->event, $timing_date->event_date);
                if (!$event_timing_list) {
                    continue;
                }

                foreach ($event_timing_list as $event_time) {
                    $event_ticket_list = EventTiming::get_ticket_list($timing_date->event, $event_time->id);
                    foreach ($event_ticket_list as $ticket) {
                        $availability = EventTiming::get_available_tickets($ticket->id);
                        if ($availability <= 0) {
                            continue;
                        }

                        $allTickets[] = [
                            'ticket' => $ticket,
                            'availability' => $availability,
                            'event_date' => $event_time->event_date,
                            'from_time' => $event_time->from_time,
                            'to_time' => $event_time->to_time,
                        ];
                    }
                }
            }

            usort($allTickets, function ($a, $b) {
                $priceA = (float) ($a['ticket']->web_price ?? $a['ticket']->ticket_amount ?? 0);
                $priceB = (float) ($b['ticket']->web_price ?? $b['ticket']->ticket_amount ?? 0);

                return $priceA <=> $priceB;
            });

            $prices = array_map(function ($item) {
                return (float) ($item['ticket']->web_price ?? $item['ticket']->ticket_amount ?? 0);
            }, $allTickets);

            $minPrice = $prices ? min($prices) : 0;
            $maxPrice = $prices ? max($prices) : 0;
            $lowestPrice = $minPrice;
            $listingCount = count($allTickets);
            $totalAvailableSeats = array_sum(array_map(fn ($item) => $item['availability'], $allTickets));
            $maxQuantityOption = $allTickets
                ? min(6, max(array_map(fn ($item) => (int) $item['availability'], $allTickets)))
                : 1;
            $maxQuantityOption = max(1, $maxQuantityOption);

            $restrictionMap = RestrictionModel::pluck('restrictions', 'id')->all();
            foreach ($allTickets as $index => &$item) {
                $ticket = $item['ticket'];
                $price = (float) ($ticket->web_price ?? $ticket->ticket_amount ?? 0);
                $faceValue = (float) ($ticket->face_value ?? 0);

                $restrictionIds = $ticket->ticket_restrictions ? json_decode($ticket->ticket_restrictions, true) : [];
                $item['restrictions'] = is_array($restrictionIds)
                    ? array_values(array_filter(array_map(fn ($rid) => $restrictionMap[$rid] ?? null, $restrictionIds)))
                    : [];

                $sectionParts = array_filter([
                    $ticket->seating_type_name ?? null,
                    $ticket->row ? 'Row ' . $ticket->row : null,
                ]);
                if (empty($sectionParts) && $ticket->seat_from && $ticket->seat_to) {
                    $sectionParts[] = 'Seats ' . $ticket->seat_from . '–' . $ticket->seat_to;
                }
                $item['section_label'] = $sectionParts ? implode(', ', $sectionParts) : ($ticket->ticket_name ?? 'General Admission');
                $item['price'] = $price;
                $item['face_value'] = $faceValue;
                $item['has_eticket'] = !empty($ticket->ticket_upload);
                $item['is_cheapest'] = $listingCount > 0 && abs($price - $lowestPrice) < 0.01;
                $item['is_best_value'] = $index === 0;
                $item['value_score'] = $faceValue > 0 && $price > 0
                    ? min(10, round(max(7, 10 - (($price / $faceValue) * 2)), 1))
                    : ($item['is_cheapest'] ? 9.8 : 8.7);
            }
            unset($item);

            return view('customer.show_details_show', compact(
                'settings',
                'id',
                'event_datas',
                'event_images',
                'event_reviews',
                'artist_data',
                'event_reviews_stars',
                'event_timing',
                'event_timings',
                'venue_seating',
                'available_zones',
                'allTickets',
                'minPrice',
                'maxPrice',
                'lowestPrice',
                'listingCount',
                'totalAvailableSeats',
                'maxQuantityOption'
            ));

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
            $purchase = TicketPurchase::where('id', $id)
                ->where('user_id', Auth::id())
                ->firstOrFail();

            $pdf = app(\App\Services\PurchaseInvoiceService::class)->generatePdf($purchase->id);

            return $pdf->download(app(\App\Services\PurchaseInvoiceService::class)->getInvoiceFilename($purchase->id));
           }

    public function customer_profile_settings(){
        $countries = CountryModel::orderBy('country_name')->get();

        return view('customer.profile', compact('countries'));
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
    $request->validate([
        'name' => 'required|string|max:255',
        'phone' => 'nullable|string|max:50',
        'date_of_birth' => 'nullable|date',
        'address' => 'nullable|string|max:500',
        'shipping_name' => 'nullable|string|max:255',
        'shipping_address2' => 'nullable|string|max:500',
        'shipping_country' => 'nullable|exists:countries,id',
        'shipping_city' => 'nullable|string|max:255',
        'shipping_pincode' => 'nullable|string|max:20',
        'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    ]);

    $profile = User::find(Auth::user()->id);

    $profile->name = $request->name;
    $profile->date_or_birth = $request->filled('date_of_birth')
        ? date('Y-m-d', strtotime($request->date_of_birth))
        : null;
    $profile->phone = $request->phone;
    $profile->address = $request->address;
    $profile->shipping_name = $request->shipping_name;
    $profile->shipping_address2 = $request->shipping_address2;
    $profile->shipping_country = $request->shipping_country;
    $profile->shipping_city = $request->shipping_city;
    $profile->shipping_pincode = $request->shipping_pincode;

    if ($request->hasFile('profile')) {
        $imageName = rand() . '.' . $request->profile->extension();
        $request->profile->move(storage_path('uploads/images'), $imageName);
        $profile->profile = $imageName;
    }

    $profile->save();

    return redirect()->back()->with('success', 'Profile updated successfully.');
}

}
