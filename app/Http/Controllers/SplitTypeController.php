<?php

namespace App\Http\Controllers;

use App\Models\SplitTypeModel;
use Illuminate\Http\Request;

class SplitTypeController extends Controller
{
    public function index()
    {

        $datas = SplitTypeModel::get();

        return view('reseller.split_type',compact('datas'));
    }
}
