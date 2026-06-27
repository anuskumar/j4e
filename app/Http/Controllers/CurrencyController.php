<?php

namespace App\Http\Controllers;

use App\Models\Currency;
use Illuminate\Http\Request;

class CurrencyController extends Controller
{
    public function index()
    {


        $data = Currency::orderBy('id', 'desc')->get();
        // dd($data);
        return view('admin.currency.list', compact('data'));
    }

    public function show(string $id)
    {


        $data = Currency::find($id);
        // dd($data);
        return view('admin.currency.view', compact('data'));
    }

    public function create()
    {
        return view('admin.currency.create');
    }
    public function edit(string $id)
    {
        $data = Currency::find($id);
        return view('admin.currency.edit', compact('data'));
    }

    public function store(Request $request)
    {
        // dd($request->request);

        $validated = $request->validate([
            'name' => 'required',
            'short_name' => 'required',
            'currency_rate' => 'required',

        ]);

        $data = new Currency();
        $data->name = $request->name;
        $data->short_name = $request->short_name;
        $data->symbol = $request->symbol;
        $data->currency_rate = $request->currency_rate;
        $data->is_active = $request->is_active;
        $data->save();

        return redirect('currency/list')->with('success', 'Currency created successfully.');
    }
    public function update(Request $request)
    {

        $validated = $request->validate([
            'name' => 'required',
            'short_name' => 'required',
            'currency_rate' => 'required',

        ]);

        $data = Currency::find($request->id);
        $data->name = $request->name;
        $data->short_name = $request->short_name;
        $data->symbol = $request->symbol;
        $data->currency_rate = $request->currency_rate;
        $data->is_active = $request->is_active;

        //   $data->status=$request->status;

        $data->save();
        return redirect('currency/list');
    }
    public function delete($id)
    {
        $data = Currency::find($id);
        $data->delete($id);
        return redirect('/currency/list');
    }

    //currency conversion 
    public function getRate($id)
    {
        $currency = Currency::find($id);

        if (!$currency) {
            return response()->json(['error' => 'Currency not found'], 404);
        }

        return response()->json([
            'rate' => $currency->currency_rate
        ]);
    }
}
