<?php

namespace App\Http\Controllers;



use Illuminate\Http\Request;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\DB;
use Redirect;
use Response;
use Session;


class FilterController extends Controller
{

    public function index()
    {
        $regions = DB::table('regions')->get();
        $cities = DB::table('city')->get();
        $min = DB::table('markers')->min('price');
        $max = DB::table('markers')->max('price');
        $price = $min.';'.$max;
        return view('map3', [
            'price' => $price,
            'min' => $min,
            'max' => $max,
            'kraj'=> 'all',
            'regions' => $regions,
            'cities' => $cities
        ]);
    }
    public function show($price,$price2,$kraj,$mesto)    {
            if ($kraj == 'all')
            {
                if ($mesto == 'all')
                {
                  $filter = DB::table('markers')
                      ->whereBetween('price', [$price, $price2])->get();
                }
                else
                {
                $filter = DB::table('markers')
                    ->whereBetween('price', [$price, $price2])
                    ->where('mesto','=', $mesto)->get();
                }
            }
            else
                {
                    if ($mesto != 'all')
                    {
                        $filter = DB::table('markers')
                            ->whereBetween('price', [$price, $price2])
                            ->where('kraj', '=', $kraj)
                            ->where('mesto','=', $mesto)->get();
                    }
                    else {
                        $filter = DB::table('markers')
                            ->whereBetween('price', [$price, $price2])
                            ->where('kraj', '=', $kraj)->get();
                    }

            }

        return response()->view('list', ["markers" => $filter])->header('Content-Type', 'text/xml');
    }

    public function mesta($mesta){
        //$input = Input::get('option');
        $zoznam = DB::table('city')
            ->where('region_id', $mesta)
            ->orderBy('id', 'desc')->get();
        return $zoznam;
        //return Response::json($zoznam);
    }

    public function change(Request $request) {
        $regions = DB::table('regions')->get();
        $min = DB::table('markers')->min('price');
        $max = DB::table('markers')->max('price');
        $price = Input::get("price");
        $kraj = Input::get("kraj");

        return view('map3', [
            'price' => $price,
            'min' => $min,
            'max' => $max,
            'kraj' => $kraj,
            'regions' => $regions
        ]);
      }
}
