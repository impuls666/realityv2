<?php

namespace App\Http\Controllers;

use App\Marker;
use DB;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $regions = DB::table('regions')->get();
        $cities = DB::table('city')->get();
        return view('home', [
            'regions' => $regions,
            'cities' => $cities,
        ]);
    }
    public function store()
    {

    }




}
