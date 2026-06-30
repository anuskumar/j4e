<?php

namespace App\Http\Controllers;

use App\Models\AddressModel;
use App\Models\ArtistField;
use App\Models\ArtistModel;
use App\Models\Bankmodel;
use App\Models\BankTransferDetail;
use App\Models\CityModel;
use App\Models\CountryModel;
use App\Models\Currency;
use App\Models\EventImages;
use App\Models\Events;
use App\Models\EventTickets;
use App\Models\EventTiming;
use App\Models\EventType;
use App\Models\LocationModel;
use App\Models\MobileApplication;
use App\Models\ResellerModel;
use App\Models\ResellerSuccess;
use App\Models\RestrictionModel;
use App\Models\SellerPostalAddress;
use App\Models\SplitTypeModel;
use App\Models\TicketsGenerated;
use App\Models\TicketStatus;
use App\Models\TicketType;
use App\Models\User;
use App\Models\VenueModel;
use App\Models\VenueSeating;
use App\Models\VenueType;
use App\Services\NotificationService;
use Carbon\Carbon;
use Faker\Provider\ar_EG\Address;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;


class ResellerController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = User::leftjoin('resellers', 'resellers.user_id', 'users.id')
            ->select('*', 'users.id as id', 'resellers.id as resellers_id')
            ->where('users.user_type', 'reseller')
            ->orderBy('users.created_at', 'desc')
            ->orderBy('users.id', 'desc')
            ->get();
        return view('admin.reseller.list', compact('data'));
    }
    public function eventlisting()
    {
        $eventdatas = EventType::select('event_type_name', 'id')->where('is_active', 1)->get();
        foreach ($eventdatas as $val) {
            $val['tags'] = Events::leftjoin('event_tags', 'event_tags.id', 'event.event_tag')->select('event_tags.id', 'event_tags.tag_name')->where('event_type', $val->id)->groupBy('event.event_tag')->whereNotNull('event.event_tag')->get();
        }

        //   dd($eventdatas);

        return view('reseller.event_listing_inner', compact('eventdatas'));
    }
    public function eventdata(Request $request)
    {
        $id             = $request->id;
        $eventdatalists = Events::join('event_type', 'event_type.id', 'event.event_type')->where('event.event_type', $id)->get();
        return view('reseller.event_datalisting', compact('eventdatalists'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $reseller_create = User::get();
        //  dd($customer_create);
        return view('admin.reseller.create', compact('reseller_create'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6|confirmed',
            'password_confirmation' => 'required|string|min:6',
            'phone' => 'required|string|max:20',
            'country_code' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'nullable|in:0,1',
        ], [
            'name.required' => 'User name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters long.',
            'password.confirmed' => 'Password and confirm password do not match.',
            'password_confirmation.required' => 'Please confirm the password.',
            'phone.required' => 'Phone number is required.',
            'profile.image' => 'Profile photo must be an image file.',
            'profile.mimes' => 'Profile photo must be JPG, PNG, GIF, or WEBP.',
            'profile.max' => 'Profile photo must not exceed 2MB.',
        ]);

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->user_type = 'reseller';
        $user->password = Hash::make($request->password);
        $user->email_added_at = now();
        $user->is_active = $request->has('is_active') ? $request->is_active : 1;

        $countryCode = $request->filled('country_code') ? $request->country_code : '+91 (IN)';
        $user->phone = $countryCode . ' ' . $request->phone;

        if ($request->filled('address')) {
            $user->address = $request->address;
        }

        if ($request->hasFile('profile')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->file('profile')->extension();
            $request->file('profile')->move(storage_path('uploads/images'), $imageName);
            $user->profile = $imageName;
        }

        $user->save();

        $reseller = new ResellerModel();
        $reseller->user_id = $user->id;
        $reseller->save();

        $user->sendEmailVerificationNotification();

        return redirect('admin/reseller/list')->with('success', 'Reseller created successfully!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $data = User::leftjoin('resellers', 'resellers.user_id', 'users.id')
            ->select('*', 'users.id as id', 'resellers.id as customer_id')->where('users.id', $id)->first();
        // ->paginate(2);

        return view('admin.reseller.view', compact('data'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $data = User::leftJoin('resellers', 'resellers.user_id', 'users.id')
            ->select('users.*', 'users.id as id', 'resellers.is_admin_approved', 'resellers.is_trusted')
            ->where('users.id', $id)
            ->where('users.user_type', 'reseller')
            ->first();

        if (!$data) {
            return redirect('admin/reseller/list')->with('error', 'Reseller not found.');
        }

        return view('admin.reseller.edit', compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required|exists:users,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->id,
            'phone' => 'required|string|max:20',
            'country_code' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
            'is_active' => 'nullable|in:0,1',
            'is_admin_approved' => 'nullable|in:0,1',
            'is_trusted' => 'nullable|in:0,1',
        ], [
            'name.required' => 'User name is required.',
            'email.required' => 'Email is required.',
            'email.unique' => 'This email is already registered.',
            'phone.required' => 'Phone number is required.',
            'profile.image' => 'Profile photo must be an image file.',
            'profile.mimes' => 'Profile photo must be JPG, PNG, GIF, or WEBP.',
            'profile.max' => 'Profile photo must not exceed 2MB.',
        ]);

        $data = User::find($request->id);
        if (!$data) {
            return redirect('admin/reseller/list')->with('error', 'Reseller not found.');
        }

        if ($data->email !== $request->email) {
            $data->email_added_at = now();
        }

        $data->name = $request->name;
        $data->email = $request->email;
        $data->address = $request->address;
        $data->is_active = $request->has('is_active') ? $request->is_active : 0;

        $countryCode = $request->filled('country_code') ? $request->country_code : '+91 (IN)';
        $data->phone = $countryCode . ' ' . $request->phone;

        if ($request->hasFile('profile')) {
            $imageName = time() . '_' . uniqid() . '.' . $request->file('profile')->extension();
            $request->file('profile')->move(storage_path('uploads/images'), $imageName);
            $data->profile = $imageName;
        }

        $data->save();

        $val = ResellerModel::where('user_id', $request->id)->first();
        if ($val) {
            $val->is_admin_approved = $request->input('is_admin_approved', 0);
            $val->is_trusted = $request->input('is_trusted', 0);
            $val->save();
        }

        return redirect('admin/reseller/list')->with('success', 'Reseller updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function delete(string $id)
    {
        $user = User::find($id);

        if ($user) {
            ResellerModel::where('user_id', $id)->delete();
            $user->delete();
        }

        return redirect('/admin/reseller/list');
    }

    public function profile()
    {
        $authdata = User::where('users.id', Auth::id())->first();

        $bankData = null;
        $adreesdata = null;
        $country = collect();

        if (Auth::user()->user_type === 'reseller') {
            $authdata = User::leftJoin('reseller_profiles', 'reseller_profiles.reseller_id', '=', 'users.id')
                ->select('users.*', 'reseller_profiles.reseller_id', 'reseller_profiles.reseller_image')
                ->where('users.id', Auth::id())
                ->first();
            $bankData = Bankmodel::where('resellerid', Auth::id())->first();
            $adreesdata = SellerPostalAddress::where('resellerid', Auth::id())->first();
            $country = CountryModel::get();
        }

        return view('reseller.profile', compact('authdata', 'bankData', 'adreesdata', 'country'));
    }

    public function updateprofile(Request $request)
    {
        $request->validate([
            'authid' => 'required|integer',
            'name' => 'required|string|max:255',
            'company_email' => 'required|email|max:255',
            'contact_number' => 'required|string|max:50',
            'profile' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        ]);

        if ((int) $request->authid !== Auth::id()) {
            abort(403);
        }

        $profiledata = User::findOrFail($request->authid);

        if ($profiledata->email !== $request->company_email) {
            $profiledata->email_added_at = now();
        }

        $profiledata->name = $request->name;
        $profiledata->email = $request->company_email;
        $profiledata->phone = $request->contact_number;

        if ($request->hasFile('profile')) {
            $uploadPath = storage_path('uploads/images');
            if (! is_dir($uploadPath)) {
                mkdir($uploadPath, 0755, true);
            }

            $imageName = time() . '_' . uniqid() . '.' . $request->file('profile')->extension();
            $request->file('profile')->move($uploadPath, $imageName);
            $profiledata->profile = $imageName;
        }

        $profiledata->save();

        return redirect()->back()->with('success', 'Profile updated successfully.');
    }

    public function updatebankdata(Request $request)
    {

        // return $request->all();
        $data = Bankmodel::where('resellerid', Auth::user()->id)->first();
        // return $data;
        if ($data == '') {
            $bankData = new Bankmodel;
        } else {

            $bankData = Bankmodel::find($data->id);
        }

        $bankData->resellerid   = Auth::user()->id;
        $bankData->bank_name    = $request->name;
        $bankData->bank_email   = $request->bankname;
        $bankData->bank_country = $request->bank_country;
        $bankData->accnt_no     = $request->bankaccno;
        $bankData->bic          = $request->bankbic;
        $bankData->comments     = $request->bankcomments;
        $bankData->save();
        return redirect()->back()->with('success', 'Bank Details updated successfully.');
    }

    public function updateaddressdata(Request $request)
    {

        $data = SellerPostalAddress::where('resellerid', Auth::user()->id)->first();
        if ($data == '') {
            $addressdata = new SellerPostalAddress;
        } else {

            $addressdata = SellerPostalAddress::find($data->id);
        }

        //  $addressdata=AddressModel::where('resellerid',Auth::user()->id)->first();
        $addressdata->name          = $request->name;
        $addressdata->address_line1 = $request->address_line1;
        $addressdata->address_line2 = $request->address_line2;
        $addressdata->city          = $request->city;
        $addressdata->postcode      = $request->postcode;
        $addressdata->country       = $request->country;
        $addressdata->resellerid    = Auth::user()->id;
        $addressdata->phone         = $request->phone;
        $addressdata->save();
        return redirect()->back()->with('success', 'Address Details updated successfully.');
    }

    public function updatePassword(Request $request)
    {
        // Validate the request data
        $request->validate([
            'oldpassword'      => 'required',
            'newpassword'      => 'required|string|min:8|different:oldpassword',
            'confirm_password' => 'required|string|same:newpassword',
        ]);

        $user = User::findOrFail($request->id);

        // Check if the old password matches
        if (! password_verify($request->oldpassword, $user->password)) {
            return redirect()->back()->withErrors(['oldpassword' => 'The old password is incorrect.']);
        }

        // Update the password
        $user->password = bcrypt($request->newpassword);
        $user->save();

        return redirect()->back()->with('success', 'Password updated successfully.');
    }

    public function manage_event()
    {

        $data = Events::leftjoin('event_type', 'event_type.id', 'event.event_type')
            ->leftjoin('users', 'users.id', 'event.event_added_by')
            ->leftjoin('venue', 'venue.id', 'event.venue')->leftjoin('location', 'location.id', 'venue.location')
            ->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')
            ->select('*', 'event.id as id', 'country_name', 'cities.name as city_name', 'location_name', 'venue.name as venue_name');
        $all       = $data->paginate(10);
        $upcomming = $data->whereDate('event_to_date', '>=', Carbon::now())->paginate(10);

        //    dd($data);
        return view('reseller.manage_event', compact('all', 'upcomming'));
    }
    public function manage_event_create()
    {

        // dd("hello");

        $event_type = EventType::get();
        $venue      = VenueModel::leftjoin('location', 'location.id', 'venue.location')
            ->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')
            ->select('venue.id as id', 'country_name', 'cities.name as city_name', 'location_name', 'venue.name as venue_name')
            ->get();
        $artists = ArtistModel::leftjoin('artist_field', 'artist_field.id', 'artist.field')->select('*', 'artist.id as id')->get();
        $ticketTypes = TicketType::where('is_active', 1)->get();
        // dd($event_type);
        return view('reseller.create_event', compact('event_type', 'venue', 'artists', 'ticketTypes'));
    }

    public function manage_event_store(Request $request)
    {
        // dd($request->request);
        $validated = $request->validate([
            'event_name'      => 'required',
            'event_is_active' => 'required',
        ]);

        $event                  = new Events();
        $event->event_name      = $request->event_name;
        $event->event_type      = $request->event_type;
        $event->venue           = $request->venue;
        $event->artists         = json_encode($request->artists);
        if (!empty($request->ticket_types)) {
            $event->ticket_types = json_encode($request->ticket_types);
        }
        $event->event_from_date = $request->event_from_date;
        $event->event_to_date   = $request->event_to_date;
        $event->event_desc      = $request->event_desc;
        $event->event_added_by  = Auth::user()->id;
        // $event->event_image = $request->event_image;
        if ($request->hasFile('event_image')) {
            $imageName = time() . '.' . $request->event_image->extension();
            $request->event_image->move(storage_path('uploads/events'), $imageName);
            $event->event_image = $imageName;
        }
        $event->event_is_active = $request->event_is_active;

        $event->save();

        app(NotificationService::class)->notifyEventCreated($event);

        return redirect('reseller/manage_event');
    }

    public function event_show($id)
    {
        $data = Events::leftjoin('event_type', 'event_type.id', 'event.event_type')
            ->leftjoin('users', 'users.id', 'event.event_added_by')
            ->leftjoin('venue', 'venue.id', 'event.venue')->leftjoin('location', 'location.id', 'venue.location')
            ->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')
            ->select('*', 'event.id as id', 'venue.id as id', 'country_name', 'cities.name as city_name', 'location_name', 'venue.name as venue_name')
            ->find($id);
        $artists = ArtistModel::leftjoin('artist_field', 'artist_field.id', 'artist.field')->select('*', 'artist.id as id')->get();

        //    dd($data);
        return view('reseller.event_view', compact('data', 'artists'));
    }

    public function event_edit(string $id)
    {
        $event_type = EventType::get();
        $data       = Events::find($id);
        $venue      = VenueModel::leftjoin('location', 'location.id', 'venue.location')
            ->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')
            ->select('venue.id as id', 'country_name', 'cities.name as city_name', 'location_name', 'venue.name as venue_name')
            ->get();
        $artists = ArtistModel::leftjoin('artist_field', 'artist_field.id', 'artist.field')->select('*', 'artist.id as id')->get();
        $ticketTypes = TicketType::where('is_active', 1)->get();
        return view('reseller.event_edit', compact('data', 'event_type', 'artists', 'venue', 'ticketTypes'));
    }

    public function event_update(Request $request)
    {

        // dd($request->request);

        $validated = $request->validate([
            'event_name' => 'required',
            // 'event_is_active' => 'required'
        ]);

        $data                  = Events::find($request->id);
        $data->event_name      = $request->event_name;
        $data->event_type      = $request->event_type;
        $data->event_desc      = $request->event_desc;
        $data->venue           = $request->venue;
        $data->artists         = json_encode($request->artists);
        if (!empty($request->ticket_types)) {
            $data->ticket_types = json_encode($request->ticket_types);
        }
        $data->event_from_date = $request->event_from_date;
        $data->event_to_date   = $request->event_to_date;
        // $data->event_added_by =Auth::user()->id;
        $data->event_is_active = $request->event_is_active;

        // $event->event_image = $request->event_image;
        if ($request->hasFile('event_image')) {
            $imageName = time() . '.' . $request->event_image->extension();
            $request->event_image->move(storage_path('uploads/events'), $imageName);
            $data->event_image = $imageName;
        }
        // $data->event_is_active = $request->event_is_active;

        $data->save();

        return redirect('reseller/manage_event');
    }

    public function delete_event($id)
    {
        $data = Events::find($id);
        $data->delete();
        return redirect('/reseller/manage_event');
    }

    public function multi_images($id)
    {

        $data = EventImages::where('event', $id)->get();
        return view('reseller.event_images', compact('data', 'id'));
    }
    public function upload_event_images(Request $request)
    {

        // //    dd($request->request);

        //     if($request->hasFile('image')){
        //         // dd('helllo');
        //         foreach ($request->File('image') as $key) {

        //             $val = new EventImages();
        //             $val->event = $request->event;

        //             $imageName = time().'.'.Str::random(9).$key->extension();
        //             $key->move(storage_path('uploads/events'), $imageName);
        //             $val->image =  $imageName;
        //             $val->save();

        //     }

        //     return redirect()->back();
        //    }else{

        //     return redirect()->back();

        //    }

    }
    public function event_timings($id)
    {

        $data = EventTiming::where('event', $id)->get();
        return view('reseller.event_timings', compact('data', 'id'));
    }
    public function store_timings(Request $request)
    {

        // dd($request->request);

        $val             = new EventTiming();
        $val->event      = $request->event;
        $val->event_date = $request->event_date;
        $val->from_time  = $request->from_time;
        $val->to_time    = $request->to_time;
        $val->is_active  = $request->is_active;
        $val->save();

        return back();
    }
    public function edit_timings(string $id)
    {
        $data = EventTiming::find($id);

        return view('reseller.edit_eventtimings', compact('data', 'id'));
    }
    public function update_timings(Request $request)
    {

        // dd($request->request);
        $validated = $request->validate([

            'event_date' => 'required',
            'from_time'  => 'required',

        ]);

        $data             = EventTiming::find($request->id);
        $data->id         = $request->id;
        $data->event_date = $request->event_date;
        $data->from_time  = $request->from_time;
        $data->to_time    = $request->to_time;

        $data->is_active = $request->is_active;
        //    $data->image = $request->image;

        $data->save();

        return redirect('reseller/event_timings' . '/' . $data->event);
        //  return redirect()->back();

    }
    public function delete_timings($id)
    {
        $data = EventTiming::find($id);
        $data->delete();
        return redirect('/reseller/event_timings' . '/' . $data->event);
    }

    public function manage_artist()
    {

        $data = ArtistModel::leftjoin('artist_field', 'artist_field.id', 'artist.field')->select('*', 'artist.id as id', 'field_name')->get();
        // dd($data);
        return view('reseller.manage_artist', compact('data'));
    }

    public function artist_create()
    {
        //
        $artist_create = ArtistField::get();
        //  dd($customer_create);
        $artist = ArtistModel::leftjoin('artist_field', 'artist_field.id', 'artist.field')->select('*', 'artist.id as id')->get();
        return view('reseller.artist_create', compact('artist_create', 'artist'));
    }

    public function artist_store(Request $request)
    {
        // dd($request->request);

        $validated = $request->validate([
            'artist_name' => 'required|string|max:255',
            'field' => 'required|exists:artist_field,id',
            'contact_number' => 'required|string|max:20',

        ], [
            'artist_name.required' => 'Artist name is required.',
            'field.required' => 'Artist field is required.',
            'field.exists' => 'Please select a valid artist field.',
            'contact_number.required' => 'Contact number is required.',
        ]);

        $artistuser                 = new ArtistModel();
        $artistuser->artist_name    = $request->artist_name;
        $artistuser->field          = $request->field;
        $artistuser->contact_number = $request->contact_number;
        $artistuser->about          = $request->about ?? '';
        $artistuser->save();
        return redirect('reseller/manage_artist');
    }

    public function artist_show(string $id)
    {

        $data   = ArtistModel::find($id);
        $artist = ArtistModel::leftjoin('artist_field', 'artist_field.id', 'artist.field')->select('*', 'artist.id as id', 'field_name')->get();
        // dd($data);
        return view('reseller.artist_view', compact('data', 'artist'));

        // $data = VenueModel::find($id);
        // return view('admin.venue.view',compact('data'));
    }

    public function artist_edit($id)
    {
        $data          = ArtistModel::leftjoin('artist_field', 'artist_field.id', 'artist.field')->select('*', 'artist.id as id')->find($id);
        $artist_create = ArtistField::get();

        return view('reseller.artist_edit', compact('artist_create', 'data'));
    }

    public function artist_update(Request $request)
    {

        $validated = $request->validate([
            'id'          => 'required',
            'artist_name' => 'required',

        ]);

        $data                 = ArtistModel::find($request->id);
        $data->artist_name    = $request->artist_name;
        $data->field          = $request->field;
        $data->contact_number = $request->contact_number;
        $data->about          = $request->about ?? '';

        //   $data->status=$request->status;

        $data->save();
        return redirect('reseller/manage_artist');
    }

    public function delete_artist($id)
    {
        $data = ArtistModel::find($id);
        $data->delete($id);
        return redirect('/reseller/manage_artist');
    }

    public function manage_artistfield()
    {

        $data = ArtistField::get();
        // dd($data);
        return view('reseller.manage_artistfield', compact('data'));
    }

    public function artistfield_create()
    {
        //
        $artistfield_create = ArtistField::get();
        //  dd($customer_create);
        return view('reseller.manage_artistfield', compact('artistfield_create'));
    }
    public function artistfield_store(Request $request)
    {
        // dd($request->request);

        $validated = $request->validate([
            'field_name' => 'required',

        ]);

        $artistfielduser             = new ArtistField();
        $artistfielduser->field_name = $request->field_name;

        $artistfielduser->save();
        return redirect('artistfield/manage_artistfield');
    }

    public function manage_venue()
    {

        $data = VenueModel::leftjoin('venue_type', 'venue_type.id', 'venue.venue_type')->leftjoin('location', 'location.id', 'venue.location')->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')->select("*", "venue.id as id", "venue.name as venue_name")->get();

        foreach ($data as $val) {
            $val['total_seats']      = VenueSeating::where('venue', $val->id)->sum('number_of_seats');
            $val['total_seat_types'] = VenueSeating::where('venue', $val->id)->count();
        }
        // dd($data)
        return view('reseller.manage_venue', compact('data'));
    }

    public function venue_create()
    {
        // $venue_create=VenueModel::get();
        //  dd($customer_create);
        $venue_type = VenueType::get();
        $location   = LocationModel::leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')
            ->select('*', 'location.id as id')
            ->get();
        return view('reseller.venue_create', compact('venue_type', 'location'));
    }
    public function venue_store(Request $request)
    {
        $validated = $request->validate([
            'name'     => 'required',
            'location' => 'required',
            'venue_type' => 'required',
        ]);
        // dd($request->request);
        $venue                  = new VenueModel();
        $venue->venue_type      = $request->venue_type;
        $venue->name            = $request->name;
        $venue->location        = $request->location;
        $venue->google_map_link = $request->google_map_link;
        $venue->latitude        = $request->latitude;
        $venue->longitude       = $request->longitude;
        // $venue->image = $request->image;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(storage_path('uploads/venue'), $imageName);
            $venue->image = $imageName;
        }
        $venue->save();

        return redirect('reseller/manage_venue');
    }

    public function venue_show(string $id)
    {

        $data = VenueModel::leftjoin('venue_type', 'venue_type.id', 'venue.venue_type')->leftjoin('location', 'location.id', 'venue.location')->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')->select("*", "venue.id as id", "venue.name as venue_name")->find($id);
        // dd($data);
        return view('reseller.venue_view', compact('data'));

        // $data = VenueModel::find($id);
        // return view('admin.venue.view',compact('data'));
    }

    public function venue_edit(string $id)
    {
        $data       = VenueModel::find($id);
        $venue_type = VenueType::get();
        $location   = LocationModel::leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')
            ->select('*', 'location.id as id')
            ->get();
        return view('reseller.venue_edit', compact('venue_type', 'location', 'data'));
    }

    public function venue_update(Request $request)
    {

        $validated = $request->validate([
            'id' => 'required',
            'venue_type' => 'required',
        ]);

        $data                  = VenueModel::find($request->id);
        $data->venue_type      = $request->venue_type;
        $data->name            = $request->name;
        $data->location        = $request->location;
        $data->google_map_link = $request->google_map_link;
        $data->image           = $request->image;
        if ($request->hasFile('image')) {
            $imageName = time() . '.' . $request->image->extension();
            $request->image->move(storage_path('uploads/venue'), $imageName);
            $data->image = $imageName;
        }
        $data->save();
        return redirect('reseller/manage_venue');
    }

    public function venue_delete($id)
    {
        $data = VenueModel::find($id);
        $data->delete();
        return redirect('/reseller/manage_venue');
    }

    public function ticket_index()
    {
        //
        // dd('hello');

        $data_all = Events::leftjoin('event_type', 'event_type.id', 'event.event_type')
            ->leftjoin('users', 'users.id', 'event.event_added_by')
            ->leftjoin('venue', 'venue.id', 'event.venue')->leftjoin('location', 'location.id', 'venue.location')
            ->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city');

        if (! Auth::user()->user_type == "superadmin") {

            $data_all->where('event.event_added_by', Auth::user()->id);
        }

        $data = $data_all->select('*', 'event.id as id', 'country_name', 'cities.name as city_name', 'location_name', 'venue.name as venue_name')
            ->get();
        //    dd($data);
        return view('reseller.ticket_events', compact('data'));
    }
    public function manage_tickets($id)
    {

        $data_all = EventTickets::leftjoin('ticket_type', 'ticket_type.id', 'event_tickets.ticket_type')
            ->leftjoin('event', 'event.id', 'event_tickets.event')
            ->leftjoin('venue', 'venue.id', 'event.venue')
            ->leftjoin('venue_seating', 'venue_seating.id', 'event_tickets.venue_seating')
            ->leftjoin('event_timings', 'event_timings.id', 'event_tickets.event_timing')
            ->leftjoin('ticket_status', 'ticket_status.id', 'event_tickets.ticket_status')
            ->where('event_tickets.event', $id);
        if (! Auth::user()->user_type == "reseller") {

            // $data_all->where('event.event_added_by',Auth::user()->id);
            $data_all->where('event_tickets.created_by', Auth::user()->id);
        }

        $data = $data_all->select('*', 'event_tickets.id as id', 'event_tickets.is_admin_approved as is_admin_approved')->get();

        $event          = Events::find($id);
        
        // Filter ticket types based on event's selected ticket types
        $allTicketTypes = TicketType::where('is_active', 1)->get();
        $selectedTicketTypeIds = [];
        
        if (!empty($event->ticket_types)) {
            $selectedTicketTypeIds = json_decode($event->ticket_types, true);
        }
        
        // If event has selected ticket types, filter to show only those
        // Otherwise, show all active ticket types
        if (!empty($selectedTicketTypeIds) && is_array($selectedTicketTypeIds)) {
            $ticket_type = TicketType::whereIn('id', $selectedTicketTypeIds)
                ->where('is_active', 1)
                ->get();
        } else {
            $ticket_type = $allTicketTypes;
        }
        
        $event_timing   = EventTiming::where('event', $id)->get();
        $venue_seatings = VenueSeating::leftjoin('venue', 'venue.id', 'venue_seating.venue')
            ->where('venue.id', $event->venue)->select('*', 'venue_seating.id as id')->get();
        $currency = Currency::get();
        // dd($data);
        return view('reseller.manage_tickets', compact('data', 'id', 'ticket_type', 'event_timing', 'venue_seatings', 'currency'));
    }
    public function store_ticket(Request $request)
    {
        //
        $validated = $request->validate([
            'event'           => 'required|numeric',
            'ticket_name'     => 'required',
            'event_timing'    => 'required|numeric',
            'no_of_tickets'   => 'required|numeric',
            'ticket_amount'   => 'required|numeric',
            'amount_currency' => 'required|numeric',

        ]);

        $data                            = new EventTickets();
        $data->ticket_name               = $request->ticket_name;
        $data->unique_id                 = Str::random(16);
        $data->ticket_type               = $request->ticket_type;
        $data->event                     = $request->event;
        $data->event_timing              = $request->event_timing;
        $data->no_of_tickets             = $request->no_of_tickets;
        $data->booking_expiry_date_time  = $request->booking_expiry_date_time;
        $data->no_of_tickets             = $request->no_of_tickets;
        $data->venue_seating             = $request->venue_seating;
        $data->ticket_amount             = $request->ticket_amount;
        $data->amount_currency           = $request->amount_currency;
        $data->cancellation_policy_notes = $request->cancellation_policy_notes;
        $data->disclaimer_note           = $request->disclaimer_note;

        if ($request->hasFile('image')) {
            $imageName = rand() . '.' . $request->image->extension();
            $request->image->move(storage_path('uploads/ticket_images'), $imageName);
            $data->image = $imageName;
        }

        if ($request->hasFile('cover_image')) {
            $imageName = rand() . '.' . $request->cover_image->extension();
            $request->cover_image->move(storage_path('uploads/ticket_images'), $imageName);
            $data->cover_image = $imageName;
        }

        if ($request->hasFile('map_layout')) {
            $imageName = rand() . '.' . $request->map_layout->extension();
            $request->map_layout->move(storage_path('uploads/ticket_images'), $imageName);
            $data->map_layout = $imageName;
        }

        $data->is_admin_approved = 0;
        $data->ticket_status     = 1;
        $data->created_by        = Auth::user()->id;
        $data->save();

        app(NotificationService::class)->notifyTicketCreated($data);

        // dd($request->request);

        return redirect('reseller/manage_tickets' . '/' . $request->event)->with('success', 'Ticket Created successfully');
    }

    public function ticket_create()
    {

        $data_all = Events::leftjoin('event_type', 'event_type.id', 'event.event_type')
            ->leftjoin('users', 'users.id', 'event.event_added_by')
            ->leftjoin('venue', 'venue.id', 'event.venue')->leftjoin('location', 'location.id', 'venue.location')
            ->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city');

        if (! Auth::user()->user_type == "superadmin") {

            $data_all->where('event.event_added_by', Auth::user()->id);
        }

        $data = $data_all->select('*', 'event.id as id', 'country_name', 'cities.name as city_name', 'location_name', 'venue.name as venue_name')
            ->get();
        //    dd($data);
        return view('reseller/ticket_create', compact('data'));
    }

    public function event_list_withtag($id)
    {

        // dd('hello');
        $events = Events::leftjoin('event_type', 'event_type.id', 'event.event_type')->leftjoin('event_tags', 'event_tags.id', 'event.event_tag')
            ->leftjoin('users', 'users.id', 'event.event_added_by')
            ->leftjoin('venue', 'venue.id', 'event.venue')->leftjoin('location', 'location.id', 'venue.location')
            ->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')
            ->select(
                '*',
                'event.id as id',
                'country_name',
                'cities.name as city_name',
                'location_name',
                'venue.name as venue_name',
                'event.event_image'
            )
            ->where('event_tag', $id)->get();

        foreach ($events as $val) {

            $val['timings'] = EventTiming::where('event', $val->id)->get();

            $artistIds = json_decode($val->artists, true);

            if (! empty($artistIds)) {
                $val->artist_names = ArtistModel::whereIn('id', $artistIds)->pluck('artist_name')->toArray();
            } else {
                $val->artist_names = [];
            }
        }

        return view('reseller.event_list_withtag', compact('events'));
    }

    public function selltickets(Request $request)
    {
        $id       = $request->id;
        $data_all = Events::leftJoin('venue', 'venue.id', '=', 'event.venue')
            ->leftJoin('location', 'location.id', '=', 'venue.location')
            ->leftJoin('countries', 'countries.id', '=', 'location.country')
            ->leftJoin('cities', 'cities.id', '=', 'location.city')
            ->where('event.id', $id);
        if (! Auth::user()->user_type == "superadmin") {
            $data_all->where('event.event_added_by', Auth::user()->id);
        }
        $data = $data_all->select(
            'event.id as id',
            'countries.country_name',
            'cities.name as city_name',
            'location.location_name',
            'venue.name as venue_name',
        )->first();
        $event          = Events::find($id);
        
        // Filter ticket types based on event's selected ticket types
        $allTicketTypes = TicketType::where('is_active', 1)->get();
        $selectedTicketTypeIds = [];
        
        if (!empty($event->ticket_types)) {
            $selectedTicketTypeIds = json_decode($event->ticket_types, true);
        }
        
        // If event has selected ticket types, filter to show only those
        // Otherwise, show all active ticket types
        if (!empty($selectedTicketTypeIds) && is_array($selectedTicketTypeIds)) {
            $ticket_type = TicketType::whereIn('id', $selectedTicketTypeIds)
                ->where('is_active', 1)
                ->get();
        } else {
            $ticket_type = $allTicketTypes;
        }
        
        $mobile_applications = MobileApplication::get();
        $event_timing   = EventTiming::where('event', $id)->first();
        $venue_seatings = VenueSeating::leftjoin('venue', 'venue.id', 'venue_seating.venue')
            ->where('venue.id', $event->venue)->select('*', 'venue_seating.id as id')->get();
        // dd($event->venue);
        $currency     = Currency::get();
        $restrictions = RestrictionModel::get();
        $splittypes   = SplitTypeModel::select('split_name', 'id')->where('is_active', 1)->get();
        return view('reseller.event_list_sell', compact('data', 'id', 'ticket_type', 'mobile_applications', 'event_timing', 'venue_seatings', 'currency', 'restrictions', 'splittypes', 'event'));
    }

    public function currencycodelist(Request $request)
    {
        $id     = $request->currency_code;
        $result = Currency::where('id', $id)->where('is_active', 1)->first();
        return response()->json($result);
    }
    public function savesellticket(Request $request, $id)
    {
        try {
            // Build validation rules
            $rules = [
            'ticket_count'      => 'required|numeric|min:1|max:30',
            'venue_seating'     => 'required',
            'row'               => 'nullable|string',
            'seat_from'         => 'nullable|numeric',
            'seat_to'           => 'nullable|numeric',
            'seat_reason'       => 'nullable|in:not_provided,other',
            'sell_together'     => 'required|numeric',
            'currency'          => 'required|numeric',
            'amount'            => 'required|numeric|min:0',
            'cents'             => 'nullable|numeric|min:0|max:99',
            'ticket_type'       => 'required|exists:ticket_type,id',
                'mobile_app'        => 'nullable|exists:mobile_applications,id',
            ];

            // If mobile ticket transfer, make mobile_app required
            if ($request->ticket_type == 4) {
            $rules['mobile_app'] = 'required|exists:mobile_applications,id';
        }

        // Validate the form data
        $validated = $request->validate($rules);

        // Retrieve event timing based on event ID
        $eventTiming = EventTiming::where('event', $id)->first();
        if (!$eventTiming) {
                return back()->with('error', 'Event timing not found for the given event ID.')->withInput();
        }

        // Create new ticket record
        $data = new EventTickets();

        // Basic ticket information
        $data->event = $id;
        $data->unique_id = Str::random(16);
        $data->ticket_name = "Ticket for Event #" . $id;
            $data->event_timing = $eventTiming->id;
        $data->no_of_tickets = $request->ticket_count;

        // Ticket details
        $data->ticket_type = $request->ticket_type;
        $data->venue_seating = $request->venue_seating;
        $data->row = $request->row;
        $data->seat_from = $request->seat_from;
        $data->seat_to = $request->seat_to;
        $data->split_type = $request->sell_together;

        // Price information
            $cents = $request->cents ?? 0;
        $totalAmount = $request->amount + ($cents / 100); // Convert cents to decimal
            $data->ticket_amount = $totalAmount;
        $data->amount_currency = $request->currency;
            $data->face_value = $totalAmount;

        // Process restrictions (checkboxes)
        $restrictions = $request->restrictions ?? [];
        $data->ticket_restrictions = json_encode($restrictions);
            
        // Process features (checkboxes)
        $features = [];
        $featureFields = [
            'limitedView',
            'vipPass',
            'mealPackage',
            'parking',
            'standingOnly',
            'aisleSeat'
        ];

        foreach ($featureFields as $field) {
            if ($request->has($field)) {
                $features[] = $field;
            }
        }

        // Combine restrictions and features into a single JSON field
        $allRestrictions = [
            'features' => $features
        ];

        $data->features = json_encode($allRestrictions);

        // Mobile app information if applicable
        if ($request->ticket_type == 4 && $request->has('mobile_app')) {
            $data->mobile_application_id = $request->mobile_app;
        }

        // Default values
            $data->booking_expiry_date_time = $eventTiming->event_date ?? now();
            $data->cancellation_policy_notes = "Standard cancellation policy applies.";
            $data->disclaimer_note = "No refunds or exchanges.";

        // Approval status
        $data->is_admin_approved = 0;
        $data->ticket_status = 1;
        $data->created_by = Auth::user()->id;

            // Use database transaction to ensure data integrity
            DB::beginTransaction();
            
            try {
                // Save the EventTickets record
        $data->save();

                // Create TicketsGenerated records for each seat
                // Only create if seat information is provided (seat_from, seat_to, and row)
                if ($data->seat_from && $data->seat_to && $data->row && $data->venue_seating) {
                    // Get venue seating information
                    $seating = VenueSeating::find($data->venue_seating);
                    
                    if (!$seating) {
                        throw new \Exception('Venue seating not found for the given venue seating ID.');
                    }
                    
                    // Calculate seat range
                    $seatFrom = (int)$data->seat_from;
                    $seatTo = (int)$data->seat_to;
                    $ticketCount = $seatTo - $seatFrom + 1;
                    
                    // Validate that ticket count matches
                    if ($ticketCount != $data->no_of_tickets) {
                        throw new \Exception("Ticket count mismatch. Expected {$data->no_of_tickets} tickets but seat range provides {$ticketCount} tickets.");
                    }
                    
                    // Create a ticket for each seat number
                    for ($i = $seatFrom; $i <= $seatTo; $i++) {
                        $ticketGenerated = new TicketsGenerated();
                        $ticketGenerated->event_tickets = $data->id;
                        $ticketGenerated->ticket_serial_number = ($seating->seat_serial_prefix ?? 'T') . $i . '-' . $data->row . '-' . time() . '-' . $i;
                        $ticketGenerated->is_sold = 0;
                        $ticketGenerated->under_purchase_hold = 0;
                        $ticketGenerated->ticket_amount = $data->ticket_amount;
                        $ticketGenerated->seat_number = $i;
                        $ticketGenerated->seat_row = $data->row;
                        $ticketGenerated->seat_prefix = $seating->seat_serial_prefix ?? 'T';
                        $ticketGenerated->seat_number_prefix = ($seating->seat_serial_prefix ?? 'T') . '-' . $data->row . '-' . $i;
                        $ticketGenerated->event_timing = $data->event_timing;
                        $ticketGenerated->event_seating = $data->venue_seating;
                        $ticketGenerated->event_id = $data->event;
                        $ticketGenerated->save();
                    }
                    
                    Log::info('TicketsGenerated records created', [
                        'event_tickets_id' => $data->id,
                        'tickets_created' => $ticketCount
                    ]);
                } else {
                    Log::info('TicketsGenerated not created - missing seat information', [
                        'event_tickets_id' => $data->id,
                        'has_seat_from' => !empty($data->seat_from),
                        'has_seat_to' => !empty($data->seat_to),
                        'has_row' => !empty($data->row),
                        'has_venue_seating' => !empty($data->venue_seating)
                    ]);
                }

                // Commit the transaction
                DB::commit();

                app(NotificationService::class)->notifyTicketCreated($data);

            } catch (\Exception $e) {
                // Rollback the transaction on any error
                DB::rollBack();
                
                Log::error('Error in ticket creation transaction: ' . $e->getMessage(), [
                    'event_tickets_id' => $data->id ?? null,
                    'trace' => $e->getTraceAsString()
                ]);
                
                // Re-throw the exception to be caught by outer catch block
                throw $e;
            }

            // Redirect to the next step with success message
            return redirect()->route('reseller.savesecond', ['id' => $data->id])
                ->with('success', 'Ticket created successfully!');

        } catch (\Illuminate\Validation\ValidationException $e) {
            // Validation errors
            return back()->withErrors($e->errors())->withInput()
                ->with('error', 'Please fix the validation errors below.');
        } catch (\Exception $e) {
            // Other errors (database, etc.)
            Log::error('Ticket creation error: ' . $e->getMessage(), [
                'request' => $request->all(),
                'trace' => $e->getTraceAsString()
            ]);
            
            return back()->with('error', 'An error occurred while creating the ticket: ' . $e->getMessage())
                ->withInput();
        }
    }

    public function savesellticketsecond(Request $request)
    {

        $eventid   = $request->id;
        $currencys = Currency::select('id', 'short_name', 'name', 'currency_rate', 'symbol')->where('is_active', 1)->get();
        //fetching event name
        $data = EventTickets::leftjoin('event', 'event.id', '=', 'event_tickets.event')
            ->leftjoin('event_timings', 'event_timings.event', 'event.id')
            ->leftjoin('event_type', 'event_type.id', 'event.event_type')
            ->leftjoin('event_tags', 'event_tags.id', 'event.event_tag')
            ->leftjoin('venue', 'venue.id', 'event.venue')
            ->leftjoin('location', 'location.id', 'venue.location')
            ->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')
            ->leftjoin('ticket_type', 'ticket_type.id', 'event_tickets.ticket_type')
            ->leftjoin('split_types', 'split_types.id', 'event_tickets.split_type')
            ->leftjoin('currency', 'currency.id', 'event_tickets.amount_currency')
            ->leftjoin('venue_seating', 'venue_seating.id', 'event_tickets.venue_seating')
            ->leftjoin('mobile_applications', 'mobile_applications.id', 'event_tickets.mobile_application_id')

            ->where('event_tickets.id', $eventid)
            ->select(
                'event.event_name',
                'event.event_from_date',
                'event.event_to_date',
                'event_type.event_type_name',
                'event_tags.tag_name',
                'event_timings.event_date',
                'event_timings.from_time',
                'event_timings.to_time',
                'event_timings.is_active',
                'venue.name',
                'location.location_name',
                'cities.name as cname',
                'countries.country_name',
                'ticket_type.ticket_type_name',
                'event_tickets.split_type',
                'event_tickets.row',
                'event_tickets.seat_from',
                'event_tickets.seat_to',
                'event_tickets.no_of_tickets',
                'event_tickets.face_value',
                'event_tickets.amount_currency',
                'event_tickets.ticket_amount',
                'event.seller_fee_percent',
                'split_types.split_name',
                'currency.short_name as currency_name',
                'venue_seating.seating_type_name as venue_seating_name',
                'mobile_applications.name as mobile_applications_name'
            )
            ->first();
        return view('reseller.event_savesecond', compact('currencys', 'data'));
    }
    public function showsellticketsecond(Request $request)
    {
        $lastRecord = EventTickets::where('id', $request->id)->first();
        $eventid    = $lastRecord->event;
        $currencys  = Currency::select('id', 'short_name', 'name', 'currency_rate', 'symbol')->where('is_active', 1)->get();
        $data       = EventTickets::leftjoin('event', 'event.id', '=', 'event_tickets.event')
            ->leftjoin('event_timings', 'event_timings.event', 'event.id')
            ->leftjoin('venue', 'venue.id', 'event.venue')
            ->leftjoin('location', 'location.id', 'venue.location')
            ->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')
            ->leftjoin('ticket_type', 'ticket_type.id', 'event_tickets.ticket_type')
            ->where('event_tickets.event', $eventid)
            ->select(
                'event.event_name',
                'event_timings.event_date',
                'event_timings.from_time',
                'event_timings.to_time',
                'event_timings.is_active',
                'venue.name',
                'location.location_name',
                'cities.name as cname',
                'countries.country_name',
                'ticket_type.ticket_type_name',
                'event_tickets.split_type',
                'event_tickets.row',
                'event_tickets.seat_from',
                'event_tickets.seat_to',
                'event_tickets.no_of_tickets',
                'event_tickets.face_value',
                'event_tickets.amount_currency',
                'event_tickets.ticket_amount',
                'venue_seating.seating_type_name'
            )
            ->first();
        return view('reseller.event_savesecond', compact('currencys', 'data', 'eventid'));
    }

    public function updatesavefunction(Request $request, $id)
    {
        $request->validate([
            'currency' => 'required|exists:currency,id',
            'amount'   => 'required|numeric|min:0',
            'cents'    => 'nullable|numeric|min:0|max:99',
        ]);

        $ticket = EventTickets::findOrFail($id);

        $sellerFeePercent = (float) optional(Events::find($ticket->event))->seller_fee_percent;
        if ($sellerFeePercent <= 0) {
            $sellerFeePercent = 10.00;
        }

        $websitePrice = (float) $request->converted_website_price;
        $pricePerTicket = (float) $request->converted_price_per_ticket;
        $sellerFee = round(($websitePrice * $sellerFeePercent) / 100, 2);
        $receivePerTicket = round(($pricePerTicket * (100 - $sellerFeePercent)) / 100, 2);
        $totalReceive = round($websitePrice - $sellerFee, 2);

        // Update fields
        $ticket->update([
            'amount_currency'  => $request->currency,
            'ticket_amount'    => $request->converted_price_per_ticket,
            'web_price'        => $websitePrice,
            'seller_fee'       => $sellerFee,
            'recive_perticket' => $receivePerTicket,
            'total_recive'     => $totalReceive,
        ]);

        if ($request->hasFile('proof_of_id')) {
            $imageName = time() . '.' . $request->proof_of_id->extension();
            $request->proof_of_id->move(storage_path('uploads/ticket_proof/proof_of_id'), $imageName);
            $ticket->proof_of_id = $imageName;
        }

        if ($request->hasFile('proof_of_purchase')) {
            $imageName = time() . '.' . $request->proof_of_purchase->extension();
            $request->proof_of_purchase->move(storage_path('uploads/ticket_proof/proof_of_purchase'), $imageName);
            $ticket->proof_of_purchase = $imageName;
        }

        // Fetch the required data for the sellticket_card_data view
        // $singleaddress = ResellerSuccess::leftjoin('seller_address', 'seller_address.id', 'reseller_final_proccess.address_id')
        //     ->where('reseller_final_proccess.reseller_id', Auth::user()->id)
        //     ->select('reseller_final_proccess.id as uniqid', 'seller_address.*')
        //     ->first();

        return redirect()->route('reseller.conformation', ['id' => $ticket->id])
            ->with('success', 'Ticket updated successfully.');
    }

    //Unnecessary methods, no longer needed as per the client requirements (Public function showaddresform method)

    // public function showaddresform(Request $request)
    // {

    //     $id       = $request->id;
    //     $countrys = CountryModel::select('country_name', 'id')->get();
    //     $authname = Auth::user()->name;

    //     $oldaddress   = AddressModel::where('ticketid', $id)->get();
    //     $country_name = CountryModel::get();
    //     $city         = CityModel::leftjoin('countries', 'countries.id', 'cities.country_id')->select('cities.id', 'name', 'country_name')->paginate(10);
    //     return view('reseller.event_savethird', compact('authname', 'oldaddress', 'country_name', 'city', 'id', 'countrys'));
    // }

    // //Unnecessary methods, no longer needed as per the client requirements (public function saveselltickethird method)
    // public function savesellticketthird(Request $request)
    // {
    //     // Debugging: Check the request data

    //     $address = $request->input('address_checkbox');

    //     if ($address) {
    //         $singleaddress = ResellerSuccess::where('address_id', $address)->first();

    //         if ($singleaddress) {

    //             $singleaddress->reseller_id = Auth::user()->id;
    //             $singleaddress->save();
    //         } else {
    //             $successAddress              = new ResellerSuccess();
    //             $successAddress->address_id  = $address;
    //             $successAddress->reseller_id = Auth::user()->id;

    //             $successAddress->save();
    //         }
    //         return redirect()->route('reseller.conformation');
    //     } else {

    //         $address                = new AddressModel();
    //         $address->address_line1 = $request->input('address_line1');
    //         $address->address_line2 = $request->input('address_line2');
    //         $address->city          = $request->input('city');
    //         $address->postcode      = $request->input('postcode');
    //         $address->country       = $request->input('country');
    //         $address->ticketid      = $request->id;
    //         $address->resellerid    = Auth::user()->id;
    //         $address->name          = $request->input('name');
    //         $address->phone         = $request->input('phone');
    //         $address->save();
    //         return redirect()->back()->with('success', 'Your Address is added');
    //     }

    //     //
    // }



    public function savesellconformation(Request $request)
    {
        $eventid   = $request->id;
        $currencys = Currency::select('id', 'short_name', 'name', 'currency_rate', 'symbol')->where('is_active', 1)->get();
        //fetching event name
        $data = EventTickets::leftjoin('event', 'event.id', '=', 'event_tickets.event')
            ->leftjoin('event_timings', 'event_timings.event', 'event.id')
            ->leftjoin('venue', 'venue.id', 'event.venue')
            ->leftjoin('location', 'location.id', 'venue.location')
            ->leftjoin('countries', 'countries.id', 'location.country')
            ->leftjoin('cities', 'cities.id', 'location.city')
            ->leftjoin('ticket_type', 'ticket_type.id', 'event_tickets.ticket_type')
            ->leftjoin('split_types', 'split_types.id', 'event_tickets.split_type')
            ->leftjoin('currency', 'currency.id', 'event_tickets.amount_currency')
            ->leftjoin('venue_seating', 'venue_seating.id', 'event_tickets.venue_seating')
            ->leftjoin('mobile_applications', 'mobile_applications.id', 'event_tickets.mobile_application_id')

            ->where('event_tickets.id', $eventid)
            ->select(
                'event.event_name',
                'event_timings.event_date',
                'event_timings.from_time',
                'event_timings.to_time',
                'event_timings.is_active',
                'venue.name',
                'location.location_name',
                'cities.name as cname',
                'countries.country_name',
                'ticket_type.ticket_type_name',
                'event_tickets.split_type',
                'event_tickets.row',
                'event_tickets.seat_from',
                'event_tickets.seat_to',
                'event_tickets.no_of_tickets',
                'event_tickets.ticket_amount',
                'event_tickets.seller_fee',
                'event_tickets.web_price',
                'event_tickets.total_recive',
                'split_types.split_name',
                'currency.short_name as currency_name',
                'currency.symbol',
                'venue_seating.seating_type_name as venue_seating_name',
                'mobile_applications.name as mobile_applications_name'
            )
            ->first();
        $bankDetails = BankTransferDetail::with('currency')->where('reseller_id', auth()->id())->get();
        // dd($bankDetails->toArray());
        return view('reseller.sellticket_card_data', compact('eventid', 'data', 'currencys', 'bankDetails'));
    }

    public function finalprocess(Request $request)
    {
        //return $request->cardname;

        $updateco = ResellerSuccess::find($request->uniqid);
        // return($request->uniqid);

        $updateco->card_name   = $request->cardname;
        $updateco->card_number = $request->cardnumber;
        $updateco->card_cvv    = $request->cvv;
        $updateco->exp_month   = $request->expmnth;
        $updateco->card_year   = $request->expyr;
        $updateco->save();
        //  Mail::to('sheebarobert18@gmail.com')->send(new uploadticketMail());

        return redirect('tickets')->with('success', 'Your Ticket Has been created');
    }

    public function countrycode(Request $request)
    {
        $id        = $request->country_code;
        $countryId = $request->country_code;
        $cities    = CityModel::where('country_id', $countryId)->get();
        return response()->json($cities);
    }

    public function mylistings(Request $request){

        // dd('helo');
        $data_all = EventTickets::
        leftjoin('event','event.id','event_tickets.event')->
        leftjoin('event_type','event_type.id','event.event_type')
        ->leftjoin('users','users.id','event.event_added_by')
        ->leftjoin('venue','venue.id','event.venue')->
        leftjoin('location','location.id','venue.location')
        ->leftjoin('countries','countries.id','location.country')
        ->leftjoin('cities','cities.id','location.city')
        ->leftjoin('event_timings','event_timings.id','event_tickets.event_timing')
        ->leftjoin('ticket_type','ticket_type.id','event_tickets.ticket_type')
        ->leftjoin('currency','currency.id','event_tickets.amount_currency')
        ;

        // if(!Auth::user()->user_type=="superadmin"){

            $data_all->where('event_tickets.created_by',Auth::user()->id);
        // }

        // ✅ filters
        if ($request->filled('ticket_status')) {
            $data_all->where('event_tickets.ticket_status', $request->ticket_status);
        }
         if ($request->filled('ticket_type')) {
            $data_all->where('event_tickets.ticket_type', $request->ticket_type);
        }

        if ($request->filled('start_date')) {
            $data_all->whereDate('event_tickets.event_from_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $data_all->whereDate('event_tickets.event_to_date', '<=', $request->end_date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $data_all->where(function($q) use ($search) {
                $q->where('event.event_name', 'like', "%{$search}%")
                ->orWhere('venue.name', 'like', "%{$search}%")
                ->orWhere('cities.name', 'like', "%{$search}%");
            });
        }


        $data = $data_all->select('*','event_tickets.id as id','event_tickets.is_admin_approved as is_admin_approved','event_tickets.ticket_status as ticket_status','event_tickets.event as event_id','event.event_name as event_name','country_name','cities.name as city_name','location_name','venue.name as venue_name')
       ->orderBy('event_tickets.id', 'desc')
       ->paginate(20)->appends(request()->all());

       foreach($data as $val){

        $val['waiting_for_approval'] = EventTickets::where('event_tickets.event',$val->id)->where('is_admin_approved',0)->count();
        $val['my_tickets'] = EventTickets::where('event_tickets.event',$val->id)->where('created_by',Auth::user()->id)->count();

       }

        $ticket_type = TicketType::all();
        $ticket_status = TicketStatus::all();


    //    dd($data);

     return view('reseller.mylistings',compact('data','ticket_type','ticket_status'));
    }

        public function mysales(Request $request){

        // dd('helo');
        $data_all = EventTickets::
        leftjoin('event','event.id','event_tickets.event')->
        leftjoin('event_type','event_type.id','event.event_type')
        ->leftjoin('users','users.id','event.event_added_by')
        ->leftjoin('venue','venue.id','event.venue')->
        leftjoin('location','location.id','venue.location')
        ->leftjoin('countries','countries.id','location.country')
        ->leftjoin('cities','cities.id','location.city')
        ->leftjoin('event_timings','event_timings.id','event_tickets.event_timing')
        ->leftjoin('ticket_type','ticket_type.id','event_tickets.ticket_type')
        ->leftjoin('currency','currency.id','event_tickets.amount_currency')
        ;

        // if(!Auth::user()->user_type=="superadmin"){

            $data_all->where('event_tickets.created_by',Auth::user()->id);
        // }

        // ✅ filters
        if ($request->filled('ticket_status')) {
            $data_all->where('event_tickets.ticket_status', $request->ticket_status);
        }
         if ($request->filled('ticket_type')) {
            $data_all->where('event_tickets.ticket_type', $request->ticket_type);
        }

        if ($request->filled('start_date')) {
            $data_all->whereDate('event_timings.event_date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $data_all->whereDate('event_timings.event_date', '<=', $request->end_date);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $data_all->where(function($q) use ($search) {
                $q->where('event.event_name', 'like', "%{$search}%")
                ->orWhere('venue.name', 'like', "%{$search}%")
                ->orWhere('cities.name', 'like', "%{$search}%");
            });
        }

        // Apply sales count filters using whereIn with subquery
        if ($request->filled('sales_status')) {
            $salesStatus = $request->sales_status;
            if ($salesStatus == 'has_sales') {
                $data_all->whereIn('event_tickets.id', function($query) {
                    $query->select('event_tickets')
                        ->from('event_ticket_tickets')
                        ->where('is_sold', 1)
                        ->whereNull('deleted_at')
                        ->groupBy('event_tickets')
                        ->havingRaw('COUNT(*) > 0');
                });
            } elseif ($salesStatus == 'no_sales') {
                $data_all->whereNotIn('event_tickets.id', function($query) {
                    $query->select('event_tickets')
                        ->from('event_ticket_tickets')
                        ->where('is_sold', 1)
                        ->whereNull('deleted_at');
                });
            }
        }

        if ($request->filled('min_sales')) {
            $minSales = (int)$request->min_sales;
            $data_all->whereIn('event_tickets.id', function($query) use ($minSales) {
                $query->select('event_tickets')
                    ->from('event_ticket_tickets')
                    ->where('is_sold', 1)
                    ->whereNull('deleted_at')
                    ->groupBy('event_tickets')
                    ->havingRaw('COUNT(*) >= ?', [$minSales]);
            });
        }

        if ($request->filled('max_sales')) {
            $maxSales = (int)$request->max_sales;
            $data_all->whereIn('event_tickets.id', function($query) use ($maxSales) {
                $query->select('event_tickets')
                    ->from('event_ticket_tickets')
                    ->where('is_sold', 1)
                    ->whereNull('deleted_at')
                    ->groupBy('event_tickets')
                    ->havingRaw('COUNT(*) <= ?', [$maxSales]);
            });
        }

        // Add sales count as subquery for display
        $data_all->select('*','event_tickets.id as id','event_tickets.event as event_id','event.event_name as event_name','country_name','cities.name as city_name','location_name','venue.name as venue_name')
            ->selectRaw('(SELECT COUNT(*) FROM event_ticket_tickets WHERE event_ticket_tickets.event_tickets = event_tickets.id AND event_ticket_tickets.is_sold = 1 AND event_ticket_tickets.deleted_at IS NULL) as sales_count');

        $data = $data_all->orderBy('event_tickets.id', 'desc')
            ->paginate(20)->appends(request()->all());

       foreach($data as $val){

        $val['waiting_for_approval'] = EventTickets::where('event_tickets.event',$val->id)->where('is_admin_approved',0)->count();
        $val['my_tickets'] = EventTickets::where('event_tickets.event',$val->id)->where('created_by',Auth::user()->id)->count();
        // Sales count is already calculated in the query, but we'll keep this as fallback
        if (!isset($val['sales_count']) || $val['sales_count'] === null) {
            $val['sales_count'] = TicketsGenerated::where('event_tickets', $val->id)->where('is_sold', 1)->count();
        }

       }

        $ticket_type = TicketType::all();
        $ticket_status = TicketStatus::all();


    //    dd($data);

     return view('reseller.mysales',compact('data','ticket_type','ticket_status'));
    }

    public function reseller_manage_eventticket(Request $request,$id){

        $data_all = EventTickets::
        leftjoin('event','event.id','event_tickets.event')->
        leftjoin('event_type','event_type.id','event.event_type')
        ->leftjoin('users','users.id','event.event_added_by')
        ->leftjoin('venue','venue.id','event.venue')->
        leftjoin('location','location.id','venue.location')
        ->leftjoin('countries','countries.id','location.country')
        ->leftjoin('cities','cities.id','location.city')
        ->leftjoin('event_timings','event_timings.id','event_tickets.event_timing')
        ->leftjoin('ticket_type','ticket_type.id','event_tickets.ticket_type')
        ->leftjoin('currency','currency.id','event_tickets.amount_currency')
        ->leftjoin('venue_seating','venue_seating.id','event_tickets.venue_seating')
        ->where('event_tickets.id', $id);

        $data = $data_all->select('*','event_tickets.id as id','event_tickets.created_by as created_by','event_tickets.is_admin_approved as is_admin_approved','event_tickets.web_price as web_price','event_tickets.event as event_id','event.event_name as event_name','currency.short_name as short_name','country_name','cities.name as city_name','location_name','venue.name as venue_name')
       ->get()->toArray();

        $data['waiting_for_approval'] = EventTickets::where('event_tickets.event',$data[0]['id'])->where('is_admin_approved',0)->count();
        $data['my_tickets'] = EventTickets::where('event_tickets.event',$data[0]['id'])->where('created_by',Auth::user()->id)->count();
        $data['tickets'] = TicketsGenerated::where('event_tickets',$data[0]['id'])
        ->leftjoin('event_timings','event_timings.id','event_ticket_tickets.event_timing')
        ->leftjoin('venue_seating','venue_seating.id','event_ticket_tickets.event_seating')->select('*','event_ticket_tickets.id as id')
        ->get()->toArray();
        // $data['restrictions'] = RestrictionModel::where('id',$data[0]['ticket_restrictions'])->get()->toArray();
        // dd($data);
        $ticket_type = TicketType::all();
        $evntTcket = EventTickets::find($id);
        if($evntTcket->created_by == Auth::user()->id){

            return view('reseller.reseller_manage_eventticket',compact('data','ticket_type'));

        }else{
            return back()->with('error','User Matching Failed');
        }


    }

    public function view_sold_tickets(Request $request, $id){
        
        // Verify the ticket belongs to the authenticated reseller
        $eventTicket = EventTickets::find($id);
        if(!$eventTicket || $eventTicket->created_by != Auth::user()->id){
            return back()->with('error', 'Unauthorized access or ticket not found');
        }

        // Get main ticket information
        $mainTicket = EventTickets::
        leftjoin('event','event.id','event_tickets.event')->
        leftjoin('event_type','event_type.id','event.event_type')
        ->leftjoin('users','users.id','event.event_added_by')
        ->leftjoin('venue','venue.id','event.venue')->
        leftjoin('location','location.id','venue.location')
        ->leftjoin('countries','countries.id','location.country')
        ->leftjoin('cities','cities.id','location.city')
        ->leftjoin('event_timings','event_timings.id','event_tickets.event_timing')
        ->leftjoin('ticket_type','ticket_type.id','event_tickets.ticket_type')
        ->leftjoin('currency','currency.id','event_tickets.amount_currency')
        ->leftjoin('venue_seating','venue_seating.id','event_tickets.venue_seating')
        ->where('event_tickets.id', $id)
        ->select('*','event_tickets.id as id','event_tickets.event as event_id','event.event_name as event_name','country_name','cities.name as city_name','location_name','venue.name as venue_name')
        ->first();

        // Get all sold tickets from event_ticket_tickets for this main ticket
        $soldTickets = TicketsGenerated::where('event_tickets', $id)
            ->where('is_sold', 1)
            ->leftjoin('event_timings','event_timings.id','event_ticket_tickets.event_timing')
            ->leftjoin('venue_seating','venue_seating.id','event_ticket_tickets.event_seating')
            ->leftjoin('ticket_purchase','ticket_purchase.id','event_ticket_tickets.purchase_id')
            ->leftjoin('users','users.id','ticket_purchase.user_id')
            ->select(
                'event_ticket_tickets.*',
                'event_ticket_tickets.id as ticket_id',
                'venue_seating.seating_type_name',
                'event_timings.event_date',
                'event_timings.from_time',
                'event_timings.to_time',
                'users.name as customer_name',
                'users.email as customer_email',
                'users.phone as customer_phone'
            )
            ->orderBy('event_ticket_tickets.created_at', 'desc')
            ->get();

        return view('reseller.view_sold_tickets', compact('mainTicket', 'soldTickets'));
    }

    public function update_ticket_type(Request $request){
        $id = $request->ticket_id;
        $tickey_type = $request->ticket_type;
        $data = EventTickets::find($id);
        if($data){
            $data->ticket_type = $tickey_type;
            $data->save();
            return back()->with('success','ticket type changed');
        }else{
            return back()->with('error','Error Occured');

        }
    }
        public function destroy_ticket($id)
        {
            $item = EventTickets::findOrFail($id);
            $item->delete();

            return redirect()->route('reseller.mylistings')->with('success', 'Tickets deleted successfully.');
        }
    public function update_ticket_seating(Request $request){

        $ticket = TicketsGenerated::find($request->generated_ticket_id);
        $ticket->seat_number = $request->seat_number;
        $ticket->ticket_serial_number = $request->seat_serial_number;
        $ticket->save();

        return redirect()->back()->with('success', 'Tickets Updated successfully.');
        // dd($request->all());
    }

public function upload_ticket_seating(Request $request){

    $files = $request->file('files');
    $tickets = $request->input('tickets');

    // dd($files,$tickets);

    foreach ($files as $index => $file) {
        $ticketNo = $tickets[$index] ?? null;

        if ($ticketNo) {

              $imageName = rand() . time() . '.' . $file->extension();

                    // Move to storage/uploads/ticket_images
                    $file->move(storage_path('uploads/ticket_images'), $imageName);

                    // Save in DB
                    TicketsGenerated::find($ticketNo)->update([
                        'file' => 'uploads/ticket_images/' . $imageName,
                    ]);
        }
    }
        return response()->json(['status' => 'success']);

    }

    public function upload_ticket_seating_individual(Request $request){
        // dd($request->file('files'));
        foreach ($request->file('files') as $seatId => $fileGroup) {
            // dd($fileGroup);
        if (is_array($fileGroup)) {
            // dd($fileGroup);
            foreach ($fileGroup as $file) {
                if ($file) {
                    // Generate random name with extension
                    $imageName = rand() . time() . '.' . $file->extension();

                    // Move to storage/uploads/ticket_images
                    $file->move(storage_path('uploads/ticket_images'), $imageName);

                    // Save in DB
                    TicketsGenerated::find($seatId)->update([
                        'file' => 'uploads/ticket_images/' . $imageName,
                    ]);
                }
            }
        }
    }

    return redirect()->back()->with('success', 'Tickets uploaded successfully.');
    }

    public function update_ticket_pricechange(Request $request){

        // dd($request->all());

        $ticket_id = $request->ticket_id;
        $original_price = $request->original_price;
        $sale_price = $request->sale_price;

        $data = EventTickets::find($ticket_id);

        if($original_price > 0){

            $data->face_value = $original_price;
        }

        if($sale_price > 0){

            $data->ticket_amount = $sale_price;
        }

        $data->save();

    return redirect()->back()->with('success', 'Tickets uploaded successfully.');

    }

    public function delete_generated_ticket(Request $request){
        // dd($request->all());
        $id = $request->id;
        $generatedTicket =  TicketsGenerated::find($id);
        $ticket = EventTickets::find($generatedTicket->event_tickets);
        if($ticket->no_of_tickets > 0){
           $ticket->no_of_tickets = round($ticket->no_of_tickets) - 1;
        }
        $ticket->save();
        $generatedTicket->delete();

        return response()->json(['status' => 'success']);
    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Reseller not found.',
            ], 404);
        }

        // Get status from request and ensure it's either 1 or 0
        $status = $request->input('status', 0);
        $isActive = ($status == 1 || $status === '1' || $status === true) ? 1 : 0;
        
        // Update the is_active field in users table
        $user->is_active = $isActive;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Reseller status updated successfully.',
            'status' => (int)$user->is_active,
            'is_active' => (int)$user->is_active
        ]);
    }

}
