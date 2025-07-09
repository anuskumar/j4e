<?php

namespace App\Http\Controllers;

use App\Models\CityModel;
use App\Models\CountryModel;
use App\Models\LocationModel;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    //

    public function index(){

        $data = LocationModel::
        leftjoin('countries','countries.id','location.country')
       ->leftjoin('cities','cities.id','location.city')
       ->select('location.id as id','location_name','country_name','cities.name as city_name','location_name')
       ->get();

        return view('admin.location.index',compact('data'));


    }


    public function create(Request $request){


        $country = CountryModel::get();
        return view('admin.location.create',compact('country'));


    }

    public function get_cities(Request $request){



      $search = $request->search;
      $country = $request->country;

      if($search == ''){
         $city = CityModel::orderby('name','asc')->select('id','name')->where('cities.country_id',$country)->limit(100)->get();
      }else{
         $city = CityModel::orderby('name','asc')->select('id','name')->where('name', 'like', '%' .$search . '%')->limit(100)->get();
      }

      $response = array();
      foreach($city as $employee){
         $response[] = array(
              "id"=>$employee->id,
              "text"=>$employee->name
         );
      }
      return response()->json($response);


    }




    public function store(Request $request){


        $validated = $request->validate([
            'location_name' => 'required',
            'country' => 'required',
            'city' => 'required',

        ]);

        $new = new LocationModel();
        $new->location_name = $request->location_name;
        $new->country = $request->country;
        $new->city = $request->city;
        $new->is_active = $request->is_active == 1 ? 1: 0;
        $new->save();

        return redirect('location/list');


    }
    public function edit(string $id){

    //     $data = LocationModel::
    //     leftjoin('countries','countries.id','location.country')
    //    ->leftjoin('cities','cities.id','location.city')
    //    ->select('location.id as id','location_name','country_name','cities.name as city_name','location_name')
    //    ->get($id);
    //    $location_create = CountryModel::get($id);

    //     return view('admin.location.edit',compact('data','location_create'));

    $data=LocationModel::find($id);
        $location_create=CountryModel::get();
        $location_creat = LocationModel::
        leftjoin('countries','countries.id','location.country')
       ->leftjoin('cities','cities.id','location.city')
       ->select('location.id as id','location_name','country_name','cities.name as city_name','location_name')
       ->get();
        return view('admin.location.edit',compact('location_create','location_creat','data'));


    }
    public function update(Request $request){

            // $data=LocationModel::find();

            // return view('admin.location.edit',compact('data'));
            $validated = $request->validate([
                'location_name' => 'required',
            ]);

            $data = LocationModel::find($request->id);
            $data->location_name = $request->location_name;
            $data->country = $request->country;
            $data->city = $request->city;
            $data->is_active = $request->is_active;

            $data->save();


        return redirect('location/list');

        }

        public function delete( $id)
    {
        $data=LocationModel::find($id);
        $data->delete();
        return redirect('/location/list');

    }

}
