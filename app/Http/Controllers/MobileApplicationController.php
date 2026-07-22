<?php

namespace App\Http\Controllers;

use App\Models\EventTickets;
use App\Models\MobileApplication;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class MobileApplicationController extends Controller
{
    public function index()
    {
        $mobileApplications = MobileApplication::orderBy('name')->get();

        return view('admin.mobile_applications.list', compact('mobileApplications'));
    }

    public function create()
    {
        return view('admin.mobile_applications.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255', 'unique:mobile_applications,name'],
            'is_active' => ['required', 'boolean'],
        ]);

        MobileApplication::create($validated);

        return redirect()->route('admin.mobile-applications.index')
            ->with('success', 'Mobile application created successfully.');
    }

    public function show(MobileApplication $mobileApplication)
    {
        return view('admin.mobile_applications.view', compact('mobileApplication'));
    }

    public function edit(MobileApplication $mobileApplication)
    {
        return view('admin.mobile_applications.edit', compact('mobileApplication'));
    }

    public function update(Request $request, MobileApplication $mobileApplication)
    {
        $validated = $request->validate([
            'name' => [
                'required',
                'string',
                'max:255',
                Rule::unique('mobile_applications', 'name')->ignore($mobileApplication->id),
            ],
            'is_active' => ['required', 'boolean'],
        ]);

        $mobileApplication->update($validated);

        return redirect()->route('admin.mobile-applications.index')
            ->with('success', 'Mobile application updated successfully.');
    }

    public function destroy(MobileApplication $mobileApplication)
    {
        if (EventTickets::where('mobile_application_id', $mobileApplication->id)->exists()) {
            return redirect()->route('admin.mobile-applications.index')
                ->with('error', 'This mobile application is used by existing tickets. Mark it inactive instead.');
        }

        $mobileApplication->delete();

        return redirect()->route('admin.mobile-applications.index')
            ->with('success', 'Mobile application deleted successfully.');
    }
}
