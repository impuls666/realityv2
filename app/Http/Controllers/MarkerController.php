<?php

namespace App\Http\Controllers;
use App\Marker;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Input;

class MarkerController extends Controller
{
    //
    public function index()
    {
        $markers = DB::table('markers')->get();





        return response()->view('list', ["markers" => $markers])->header('Content-Type', 'text/xml');


    }

    public function store(Request $request)
    {
        $marker = new Marker;
        $marker->name = Input::get("name");
        $marker->type = Input::get("type");


        function getLatLong($address)
        {
            if (!empty($address)) {
                //Formatted address
                $formattedAddr = str_replace(' ', '+', $address);
                //Send request and receive json data by address
                $geocodeFromAddr = file_get_contents('http://maps.googleapis.com/maps/api/geocode/json?address=' . $formattedAddr . '&sensor=false');
                $output = json_decode($geocodeFromAddr);
                //Get latitude and longitute from json data
                $data['latitude'] = $output->results[0]->geometry->location->lat;
                $data['longitude'] = $output->results[0]->geometry->location->lng;
                //Return latitude and longitude of the given address
                if (!empty($data)) {
                    return $data;
                } else {
                    return false;
                }
            } else {
                return false;
            }
        }

        $file = $request->file('image');
        $fileName = $file->getClientOriginalName();
        $destinationPath = public_path().'/images/fotky/';

        Input::file('image')->move($destinationPath, $fileName);

        $address = Input::get("address");
        $size = Input::get("size");



        $latLong = getLatLong($address);
        echo $latitude = $latLong['latitude']?$latLong['latitude']:'Not found';
        //echo '<br>';
        echo $longitude = $latLong['longitude']?$latLong['longitude']:'Not found';

        $marker->address = $address;
        $marker->lat = $latitude;
        $marker->lng = $longitude;
        $marker->displayimage = $fileName;
        $marker->size = $size;


        $marker->save();
        return redirect()->route('home')->with('status', 'Záznam pridaný');
    }

    public function showlatlongindex()
    {
        return view('latlng');
    }
    public function show($price) {



        return $post = Marker::get()->where('price','<=',$price);

    }
}
