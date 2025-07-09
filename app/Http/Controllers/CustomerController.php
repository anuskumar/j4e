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
        ->select('*','users.id as id','customers.id as customer_id')->where('users.user_type','customer')
        // ->paginate(2);
        ->get();
        // dd($data);
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
            'name' => 'required',
            'email' => 'required',
        ]);
        // if($request->has('phone')){

        //     $validated = $request->validate([
        //         'phone' => 'number',
        //     ]);

        // }

        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = $request->password;
        $user->phone = $request->phone;
        $user->address = $request->address;
        $user->user_type = 'customer';
        $user->password = Hash::make($request->password);
        $user->is_active = 1 ;
        if($request->has('phone')){

            $user->phone = $request->phone;
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

            return redirect('customer/list');

        }else{

        $login = User::find($user->id);
        Auth::login($login);
        $user = User::find(Auth::user()->id);
        $user->last_login = new DateTime();
        $user->save();

        return redirect('home');
        }


    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {


        // // dd($id);
        // $data = CustomerModel::
        // leftjoin('users','users.id','customers.user_id')
        // // ->leftjoin('admin_country','admin_country.id','admin.admin_country')
        // ->select('*','customers.id as id',)->where('users.id',$id) ->first();
        // dd($data);
        // $data = CustomerModel::find($id);


        $data = User::leftjoin('customers','customers.user_id','users.id')
        ->select('*','users.id as id','customers.id as customer_id')->where('users.id',$id) ->first();
        // ->paginate(2);



        return view('admin.customer.view',compact('data'));



    }

    /**
     * Show the form for editing the specified resource.
     */
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
            'name' => 'required',
            'email' => 'required',
        ]);

       $data=User::find($request->id);
       $data->name=$request->name;
       $data->email=$request->email;
       $data->phone=$request->phone;
       $data->address=$request->address;
       $data->save();
       return redirect('/customer/list');
    //    dd($request->request);
    // return view('admin.customer.list');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
    public function delete( $id)
    {
        $data=User::find($id);
        $data->delete();
        return redirect('/customer/list');

    }
}
