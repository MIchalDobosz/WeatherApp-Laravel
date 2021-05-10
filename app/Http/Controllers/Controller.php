<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\WeatherRecord;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Facades\Http;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function index() {
        
        $cities = City::all();
        $weatherRecords = [];

        foreach ($cities as $city) {
            $weatherRecords[] = WeatherRecord::where('city', $city->name)->orderBy('created_at', 'desc')->first();
        }
        //dd($weatherRecords);

        return view('weather', ['weatherRecords' => $weatherRecords]);
        //return $citiesWeather[0];
    }
}
