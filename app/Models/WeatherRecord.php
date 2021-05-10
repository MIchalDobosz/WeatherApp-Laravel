<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;


class WeatherRecord extends Model
{
    use HasFactory;

    protected $table = 'weather_records';
    //protected $fillable = ['omw_id'];

    
    public static function saveRecordsFromApi(array $cities = null) {

        if ($cities == null) {
            $cities = City::All();
        }
        //dd($cities);
        $apiKey = '4e61a45d24090011fc4cf874bd943d99';
        $cityWeather = "";

        foreach ($cities as $city) {
            $cityWeather = Http::get('api.openweathermap.org/data/2.5/weather', [
                'q' => $city->name,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'pl'
            ]);
            
            $weatherRecord = new WeatherRecord();
            $weatherRecord->owm_id = $cityWeather['id'];
            $weatherRecord->city = $cityWeather['name'];
            $weatherRecord->country = $cityWeather['sys']['country'];
            $weatherRecord->description = $cityWeather['weather'][0]['description'];
            $weatherRecord->icon = $cityWeather['weather'][0]['icon'];
            $weatherRecord->temp = $cityWeather['main']['temp'];
            $weatherRecord->feels_like = $cityWeather['main']['feels_like'];
            $weatherRecord->pressure = $cityWeather['main']['pressure'];
            $weatherRecord->humidity = $cityWeather['main']['humidity'];
            $weatherRecord->wind_speed = $cityWeather['wind']['speed'];
            $weatherRecord->save();
        }       
    }
}
