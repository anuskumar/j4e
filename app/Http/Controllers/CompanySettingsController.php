<?php

namespace App\Http\Controllers;

use App\Models\CompanySettings;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanySettingsController extends Controller
{

    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(){

        // dd("hello");
        $authdata = Auth::user();

        $settings = CompanySettings::where('user_id',$authdata->id)->first();

     //   return $settings;

        return view('admin.company.index',compact('settings','authdata'));

    }
    public function edit(string $id){

        // dd("hello");
       $settings=CompanySettings::find($id);
       return view('admin.company.index',compact('settings'));
    }

    public function update(Request $request){

        $validated = $request->validate([
            'id' => 'required',

        ]);





        $settings = CompanySettings::find($request->id);
        if (!$settings) {
            // If the settings don't exist, create a new instance
            $settings = new CompanySettings;
            $settings->id = $request->id; // Set the id manually if needed
        } else{
            $user = User::find($settings->user_id);
            if ($user) {
                if ($user->email !== $request->company_email) {
                    $user->email_added_at = now();
                }
                $user->email = $request->company_email;
                $user->save();
            }
        }

        $settings->company_name = $request->company_name;
        $settings->company_website = $request->company_website;
        $settings->company_footer_text = $request->company_footer_text;
        $settings->company_about = $request->company_about;
        $settings->contact_number = $request->contact_number;
        $settings->company_email = $request->company_email;
        if($request->hasFile('company_logo')){
            $imageName = rand().'.'.$request->company_logo->extension();
            $request->company_logo->move(storage_path('uploads/images'), $imageName);
            $settings->company_logo =  $imageName;
        }
        if($request->hasFile('company_logo_small')){
            $imageName = rand().'.'.$request->company_logo_small->extension();
            $request->company_logo_small->move(storage_path('uploads/images'), $imageName);
            $settings->company_logo_small =  $imageName;
        }
        if($request->hasFile('company_favicon')){
            $imageName = rand().'.'.$request->company_favicon->extension();
            $request->company_favicon->move(storage_path('uploads/images'), $imageName);
            $settings->company_favicon =  $imageName;
        }


        $settings->save();
        return redirect('admin/company_settings');
        // return view('admin.company.index',compact('settings'));

    }
}
