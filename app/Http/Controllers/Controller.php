<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\WeatherRecord;
use App\Rules\CityAlreadyExists;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\MessageBag;

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

    public function addCity(MessageBag $messageBag, Request $request) {

        $request->validate([
            'cityName' => new CityAlreadyExists
        ]);
        if (City::saveCityFromForm($request->input('cityName'))) {
            return redirect('/');
        } else {
            $messageBag->add('error', 'Nie znaleziono miasta o takiej nazwie');
            return redirect('/')->withErrors($messageBag);
        }
    }

    public function delete(Request $request) {

        $city = City::where('name', $request->input('cityName'))->first();
        City::destroy($city->id);
        return redirect('/');
    }
}
