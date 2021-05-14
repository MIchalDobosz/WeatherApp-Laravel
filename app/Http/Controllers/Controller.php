<?php

namespace App\Http\Controllers;

use App\Models\City;
use App\Models\WeatherRecord;
use App\Rules\CityAlreadyExists;
use Chartisan\PHP\Chartisan;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Support\Carbon;
use Illuminate\Support\MessageBag;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function index() {
        
        $cities = City::all();
        $currentWeatherRecords = [];
        $dailyWeatherRecords = [];
        $hourlyWeatherRecords = [];
        $dailyLabels = [];
        $dailyTemps = [];
        $dailyCharts = [];
        $hourlyLabels = [];
        $hourlyTemps = [];
        $hourlyCharts = [];
        $dailyRains = [];
        $dailyRainCharts = [];
        $hourlyRains = [];
        $hourlyRainCharts = [];
        
        $i = 0;
        foreach ($cities as $city) {

            //current
            $currentWeatherRecords[] = WeatherRecord::where([
                ['city', $city->name], 
                ['type', 'current']
            ])->orderByDesc('dt')->first();


            //daily
            $dailyWeatherRecords[] = WeatherRecord::where([
                ['city', $city->name], 
                ['type', 'daily'],
            ])->orderByDesc('created_at')->orderBy('dt')->take(8)->get();

            $tempLabels = [];
            $tempTemps = [];
            $tempRains = [];
            foreach ($dailyWeatherRecords[$i] as $dailyWeatherRecord) {
                $tempLabels[] = Carbon::parse($dailyWeatherRecord->dt)->format('d-m');
                $tempTemps[] = $dailyWeatherRecord->temp_day;
                $tempRains[] = $dailyWeatherRecord->rain;
            }
            $dailyLabels[] = $tempLabels;
            $dailyTemps[] = $tempTemps;
            $dailyRains[] = $tempRains;
            $dailyCharts[] = Chartisan::build()->labels($dailyLabels[$i])->dataset('Temperatura', $dailyTemps[$i])->toJSON();
            $dailyRainCharts[] = Chartisan::build()->labels($dailyLabels[$i])->dataset('Opady', $dailyRains[$i])->toJSON();
            
            //hourly
            $hourlyWeatherRecords[] = WeatherRecord::where([
                ['city', $city->name], 
                ['type', 'hourly'],
            ])->orderByDesc('created_at')->orderBy('dt')->take(25)->get();

            $tempLabels = [];
            $tempTemps = [];
            $tempRains = [];
            foreach ($hourlyWeatherRecords[$i] as $hourlyWeatherRecord) {
                $tempLabels[] = Carbon::parse($hourlyWeatherRecord->dt)->addHours(2)->format('H:i');
                $tempTemps[] = $hourlyWeatherRecord->temp_current;
                $tempRains[] = $hourlyWeatherRecord->rain;
            }
            $hourlyLabels[] = $tempLabels;
            $hourlyTemps[] = $tempTemps;
            $hourlyRains[] = $tempRains;
            $hourlyCharts[] = Chartisan::build()->labels($hourlyLabels[$i])->dataset('Temperatura', $hourlyTemps[$i])->toJSON();
            $hourlyRainCharts[] = Chartisan::build()->labels($hourlyLabels[$i])->dataset('Opady', $hourlyRains[$i])->toJSON();

            $i++;
        }
    
        return view('weather', [
            'currentWeatherRecords' => $currentWeatherRecords,
            'dailyCharts' => $dailyCharts,
            'hourlyCharts' => $hourlyCharts,
            'dailyRainCharts' =>$dailyRainCharts,
            'hourlyRainCharts' =>$hourlyRainCharts
        ]);
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
        WeatherRecord::where('city', $city->name)->delete();
        return redirect('/');
    }
}
