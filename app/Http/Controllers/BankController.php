<?php

namespace App\Http\Controllers;

use App\Models\Bankmodel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class BankController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
       return $data=Bankmodel::leftjoin('users','users.id','=','event_banks.resellerid')
        ->where('event_banks.resellerid', Auth::user()->id)
        ->first();

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // show create page
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        /// form data store
    }


    /**
     * Display the specified resource.
     */
    // public function show(string $id)
    // {

    // }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //show edit blade  page
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
