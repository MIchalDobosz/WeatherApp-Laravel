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
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\MessageBag;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function index() {
        
        $cities = City::all();
        $currentWeatherRecords = [];
        $dailyWeatherRecords = [];
        $hourlyWeatherRecords = [];

        foreach ($cities as $city) {
            $currentWeatherRecords[] = WeatherRecord::where([
                ['city', $city->name], 
                ['type', 'current']
            ])->orderByDesc('dt')->first();

            $dailyWeatherRecords[] = WeatherRecord::where([
                ['city', $city->name], 
                ['type', 'daily'],
                ['dt', '>=', Carbon::tomorrow()->toDateTime()],
                ['dt', '<=', Carbon::now()->addDays(7)->toDateTime()]
            ])->orderByDesc('created_at')->orderBy('dt')->take(7)->get();

            $hourlyWeatherRecords[] = WeatherRecord::where([
                ['city', $city->name], 
                ['type', 'hourly'],
                ['dt', '>', Carbon::now()->toDateTime()],
                ['dt', '<=', Carbon::now()->addHours(24)->toDateTime()]
            ])->orderByDesc('created_at')->orderBy('dt')->take(24)->get();
        }

        //dd($currentWeatherRecords);
        //dd($dailyWeatherRecords);

        return view('weather', ['currentWeatherRecords' => $currentWeatherRecords, 'dailyWeatherRecords' => $dailyWeatherRecords, 'hourlyWeatherRecords' => $hourlyWeatherRecords]);
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

    public function test() {

        $apiKey = '4e61a45d24090011fc4cf874bd943d99';
        $cityWeather = "";

        $cityWeather = Http::get('api.openweathermap.org/data/2.5/onecall', [
            'lat' => '52.2298',
            'lon' => '21.0118',
            'exclude' => 'current,alerts',
            'appid' => $apiKey,
            'units' => 'metric',
            'lang' => 'pl'
        ])->json(); 

        dd($cityWeather);
        //return $cityWeather;
    }
}
