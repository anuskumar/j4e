<?php

namespace App\Http\Controllers;

use App\Models\CityModel;
use App\Models\CountryModel;
use Illuminate\Http\Request;

class CityController extends Controller
{
    public function index(){

        $country_name = CountryModel::get();
        $data = CityModel::leftjoin('countries','countries.id','cities.country_id')->select('cities.id','name','country_name')->orderBy('cities.id', 'desc')->paginate(10);
        return view('admin.city.list',compact('country_name','data'));

}
public function create(Request $request){


    $country_name = CountryModel::get();
   return view('admin.city.create',compact('country_name'));


}
    public function show(string $id)
    {
        $data = CityModel::leftjoin('countries','countries.id','cities.country_id')
            ->select('cities.id','cities.name','country_name','cities.is_active')
            ->where('cities.id', $id)
            ->first();
        
        if (!$data) {
            return redirect('city/list')->with('error', 'City not found');
        }
        
        return view('admin.city.view',compact('data'));
    }

    public function store(Request $request)
    {
        // dd($request->request);

        $validated = $request->validate([
            'name' => 'required',
            'country_id' => 'required',
        ]);
        
        $data = new CityModel();
        $data->name = $request->name;
        $data->country_id = $request->country_id;
        $data->is_active = $request->has('is_active') ? $request->is_active : 1;
        $data->save();
        return redirect('city/list')->with('success', 'City created successfully');
     }

    public function quickStore(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'country_id' => 'required|exists:countries,id',
        ]);

        $name = trim($validated['name']);
        $countryId = (int) $validated['country_id'];

        $existing = CityModel::withTrashed()
            ->where('country_id', $countryId)
            ->whereRaw('LOWER(name) = ?', [mb_strtolower($name)])
            ->first();

        if ($existing) {
            if ($existing->trashed()) {
                $existing->restore();
            }

            $existing->name = $name;
            $existing->is_active = 1;
            $existing->save();

            return response()->json([
                'success' => true,
                'message' => 'City created successfully.',
                'data' => [
                    'id' => $existing->id,
                    'text' => $existing->name,
                ],
            ]);
        }

        $city = new CityModel();
        $city->name = $name;
        $city->country_id = $countryId;
        $city->is_active = 1;
        $city->save();

        return response()->json([
            'success' => true,
            'message' => 'City created successfully.',
            'data' => [
                'id' => $city->id,
                'text' => $city->name,
            ],
        ]);
    }

    public function edit(string $id)
    {
        $data = CityModel::find($id);
        $country_name = CountryModel::get();
        
        if (!$data) {
            return redirect('city/list')->with('error', 'City not found');
        }
        
        return view('admin.city.edit',compact('data','country_name'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'id' => 'required',
            'name' => 'required',
        ]);

        $data = CityModel::find($request->id);
        
        if (!$data) {
            return redirect('city/list')->with('error', 'City not found');
        }
        
        $data->name = $request->name;
        $data->country_id = $request->country_id;
        
        if($request->has('is_active')){
            $data->is_active = $request->is_active;
        }
        
        $data->save();
        return redirect('city/list')->with('success', 'City updated successfully');
    }

    public function delete($id)
    {
        $data = CityModel::find($id);
        
        if (!$data) {
            return redirect('city/list')->with('error', 'City not found');
        }
        
        $data->delete();
        return redirect('/city/list')->with('success', 'City deleted successfully');
    }
}
