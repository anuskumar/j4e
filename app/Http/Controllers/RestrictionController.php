<?php

namespace App\Http\Controllers;

use App\Models\RestrictionModel;
use Illuminate\Http\Request;

class RestrictionController extends Controller
{


    public function index()
    {

        $data = RestrictionModel::orderBy('id', 'desc')->get();
        // dd($data);
        return view('admin.ticket_restrictions.list',compact('data'));

    }
    public function create()
    {
        //
        $res_create=RestrictionModel::get();
        //  dd($customer_create);
            return view('admin.ticket_restrictions.create',compact('res_create'));

    }
    public function store(Request $request)
    {
        $restrictions = new RestrictionModel();
        $restrictions->restrictions = $request->restrictions;
        $restrictions->is_active = $request->is_active;
        $restrictions->save();
        return redirect('ticket_restrictions/list');

     }
}
