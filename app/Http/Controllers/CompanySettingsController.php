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

    public function index()
    {
        $authdata = Auth::user();

        $settings = CompanySettings::where('user_id', $authdata->id)->first()
            ?? CompanySettings::first();

        if (!$settings) {
            $settings = new CompanySettings();
            $settings->user_id = $authdata->id;
            $settings->company_name = 'Just 4 Entertainment';
            $settings->save();
        }

        return view('admin.company.index', compact('settings', 'authdata'));
    }
    public function edit(string $id){

        // dd("hello");
       $settings=CompanySettings::find($id);
       return view('admin.company.index',compact('settings'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'company_logo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'company_logo_small' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:4096',
            'company_favicon' => 'nullable|image|mimes:jpeg,png,jpg,webp,ico|max:2048',
        ]);

        $settings = CompanySettings::find($request->id);
        if (!$settings) {
            $settings = new CompanySettings;
            $settings->id = $request->id;
        } else {
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

        $uploadDir = storage_path('uploads/images');
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0755, true);
        }

        if ($request->hasFile('company_logo')) {
            $settings->company_logo = $this->storeBrandImage(
                $request->file('company_logo'),
                $uploadDir,
                'logo',
                $settings->company_logo
            );
        }

        if ($request->hasFile('company_logo_small')) {
            $settings->company_logo_small = $this->storeBrandImage(
                $request->file('company_logo_small'),
                $uploadDir,
                'logo_small',
                $settings->company_logo_small
            );
        }

        if ($request->hasFile('company_favicon')) {
            $settings->company_favicon = $this->storeBrandImage(
                $request->file('company_favicon'),
                $uploadDir,
                'favicon',
                $settings->company_favicon
            );
        }

        $settings->save();

        return redirect('admin/company_settings')->with('success', 'Company settings updated successfully.');
    }

    private function storeBrandImage($file, string $uploadDir, string $prefix, ?string $previousFile = null): string
    {
        $imageName = $prefix . '_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadDir, $imageName);

        if ($previousFile) {
            $previousPath = $uploadDir . DIRECTORY_SEPARATOR . $previousFile;
            if (is_file($previousPath)) {
                @unlink($previousPath);
            }
        }

        return $imageName;
    }
}
