<?php

namespace App\Http\Controllers;

use App\Models\CityModel;
use App\Models\CountryModel;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(){

        $country_name = CountryModel::get();
        $data = CityModel::leftjoin('countries','countries.id','cities.country_id')->select('cities.id','name','country_name')->paginate(10);
        return view('admin.city.list',compact('country_name','data'));

}
public function create(Request $request){


    $country_name = CountryModel::get();
   return view('admin.city.create',compact('country_name'));


}
public function store(Request $request)
    {
        // dd($request->request);

        $validated = $request->validate([
            'name' => 'required',

        ]);
        $data = CityModel::find($request->id);
        $data = new CityModel();
        $data->name = $request->name;
        $data->country_id = $request->country_id;
        $data->save();
        return redirect('city/list');
     }
}
