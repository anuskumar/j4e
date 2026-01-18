<?php

namespace App\Http\Controllers;

use App\Models\CustomerModel;
use App\Models\User;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class CustomerController extends Controller
{

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        $data = User::leftjoin('customers','customers.user_id','users.id')
        ->select('*','users.id as id','customers.id as customer_id')
        ->where('users.user_type','customer')
        ->orderBy('users.created_at', 'desc')
        ->orderBy('users.id', 'desc')
        ->get();
        
        return view('admin.customer.list',compact('data'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
     $customer_create=User::get();
    //  dd($customer_create);
        return view('admin.customer.create',compact('customer_create'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        // dd($request->request);

        // Required validation here
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:6',
            'phone' => 'nullable|string|max:20',
            'country_code' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'is_active' => 'nullable|in:0,1',
        ], [
            'name.required' => 'User name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters long.',
        ]);
       

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->user_type = 'customer';
        $user->password = Hash::make($request->password);
        $user->is_active = $request->has('is_active') ? $request->is_active : 1;
        
        if($request->has('phone') && !empty($request->phone)){
            // Store country code with name and phone number
            $countryCode = $request->has('country_code') && !empty($request->country_code) ? $request->country_code : '+91 (IN)';
            $user->phone = $countryCode . ' ' . $request->phone;
        }
        
        if($request->has('address')){
            $user->address = $request->address;
        }

        $user->save();

        $customer = new CustomerModel();
        $customer->user_id = $user->id;
        $customer->save();

        $auth = Auth::user();
        if($auth){

            return redirect('admin/customer/list')->with('success', 'Customer created successfully!');

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

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {  $data = User::leftjoin('customers','customers.user_id','users.id')
        ->select('*','users.id as id','customers.id as customer_id')->where('users.id',$id) ->first();
        return view('admin.customer.view',compact('data'));
    }

    public function edit(string $id)
    {

        $data=User::find($id);

        return view('admin.customer.edit',compact('data'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {

        // dd($request->request);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $request->id,
            'phone' => 'nullable|string|max:20',
            'country_code' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'is_active' => 'nullable|in:0,1',
        ], [
            'name.required' => 'User name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
        ]);

       $data=User::find($request->id);
       $data->name=$request->name;
       $data->email=$request->email;
       $data->is_active = $request->has('is_active') ? $request->is_active : 1;
       
       if($request->has('phone') && !empty($request->phone)){
           // Store country code with name and phone number
           $countryCode = $request->has('country_code') && !empty($request->country_code) ? $request->country_code : '+91 (IN)';
           $data->phone = $countryCode . ' ' . $request->phone;
       } else {
           $data->phone = null;
       }
       
       if($request->has('address')){
           $data->address=$request->address;
       } else {
           $data->address = null;
       }
       
       $data->save();
       return redirect('/admin/customer/list')->with('success', 'Customer updated successfully!');
    }

    /**
     * Remove the specified resource from storage.
     */
   
    public function delete( $id)
    {
        $data=User::find($id);
        $data->delete();
        return redirect('/admin/customer/list');

    }

    public function updateStatus(Request $request, $id)
    {
        $user = User::find($id);

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.',
            ], 404);
        }

        $status = $request->input('status', 0);
        $user->is_active = $status == 1 ? 1 : 0;
        $user->save();

        return response()->json([
            'success' => true,
            'message' => 'Customer status updated successfully.',
            'status' => $user->is_active
        ]);
    }
}
