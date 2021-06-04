<?php

namespace App\Models;

use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Http;
use Mockery\Undefined;

class WeatherRecord extends Model
{
    use HasFactory;

    protected $table = 'weather_records';

    
    public static function saveRecordsFromApi(array $cities = null) {

        if ($cities == null) {
            $cities = City::All();
        }
        $apiKey = '#########################';
        $currentApiResponse = "";
        $forecastApiResponse = "";

        foreach ($cities as $city) {

            if (($matchingRecords = WeatherRecord::where('city', $city->name))->exists()) {
                $matchingRecords->delete();
            } 
            
            //current
            $currentApiResponse = Http::get('api.openweathermap.org/data/2.5/weather', [
                'q' => $city->name,
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'pl'
            ]);          
            if ($currentApiResponse['cod'] == '404') return null;

            $currentWeatherRecord = new WeatherRecord();
            $currentWeatherRecord->owm_id = $currentApiResponse['id'];
            $currentWeatherRecord->lat = $currentApiResponse['coord']['lat'];
            $currentWeatherRecord->lon = $currentApiResponse['coord']['lon'];
            $currentWeatherRecord->city = $currentApiResponse['name'];
            $currentWeatherRecord->country = $currentApiResponse['sys']['country'];
            $currentWeatherRecord->dt = Carbon::createFromTimestampUTC($currentApiResponse['dt'])->toDateTime();
            $currentWeatherRecord->description = $currentApiResponse['weather'][0]['description'];
            $currentWeatherRecord->icon = $currentApiResponse['weather'][0]['icon'];
            $currentWeatherRecord->temp_current = $currentApiResponse['main']['temp'];
            $currentWeatherRecord->feels_like_current = $currentApiResponse['main']['feels_like'];
            $currentWeatherRecord->pressure = $currentApiResponse['main']['pressure'];
            $currentWeatherRecord->humidity = $currentApiResponse['main']['humidity'];
            $currentWeatherRecord->wind_speed = $currentApiResponse['wind']['speed'];
            if (isset($currentApiResponse['rain']['1h'])) $currentWeatherRecord->rain = $currentApiResponse['rain']['1h'];
            else $currentWeatherRecord->rain = 0;
            $currentWeatherRecord->type = 'current';
            $currentWeatherRecord->save();

            
            //forecast
            $forecastApiResponse = Http::get('api.openweathermap.org/data/2.5/onecall', [
                'lat' => $currentWeatherRecord->lat,
                'lon' => $currentWeatherRecord->lon,
                'exclude' => 'current,minutely,alerts',
                'appid' => $apiKey,
                'units' => 'metric',
                'lang' => 'pl'
            ]);

            //daily
            for($i=0; $i<=7; $i++) { //mozliwe i=1
                $forecastWeatherRecord = new WeatherRecord();
                $forecastWeatherRecord->owm_id = $currentWeatherRecord->owm_id;
                $forecastWeatherRecord->lat = $currentWeatherRecord->lat;
                $forecastWeatherRecord->lon = $currentWeatherRecord->lon;
                $forecastWeatherRecord->city = $currentWeatherRecord->city;
                $forecastWeatherRecord->country = $currentWeatherRecord->country;
                $forecastWeatherRecord->dt = Carbon::createFromTimestampUTC($forecastApiResponse['daily'][$i]['dt'])->toDateTime();
                $forecastWeatherRecord->description = $forecastApiResponse['daily'][$i]['weather'][0]['description'];
                $forecastWeatherRecord->icon = $forecastApiResponse['daily'][$i]['weather'][0]['icon'];
                $forecastWeatherRecord->temp_day = $forecastApiResponse['daily'][$i]['temp']['day'];
                $forecastWeatherRecord->temp_night = $forecastApiResponse['daily'][$i]['temp']['night'];
                $forecastWeatherRecord->feels_like_day = $forecastApiResponse['daily'][$i]['feels_like']['day'];
                $forecastWeatherRecord->feels_like_night = $forecastApiResponse['daily'][$i]['feels_like']['night'];
                $forecastWeatherRecord->pressure = $forecastApiResponse['daily'][$i]['pressure'];
                $forecastWeatherRecord->humidity = $forecastApiResponse['daily'][$i]['humidity'];
                $forecastWeatherRecord->wind_speed = $forecastApiResponse['daily'][$i]['wind_speed'];
                if (isset($forecastApiResponse['daily'][$i]['rain'])) $forecastWeatherRecord->rain = $forecastApiResponse['daily'][$i]['rain'];
                else $forecastWeatherRecord->rain = 0;
                $forecastWeatherRecord->type = 'daily';
                $forecastWeatherRecord->save();
            }

            //hourly
            for($i=0; $i<=24; $i++) {
                $forecastWeatherRecord = new WeatherRecord();
                $forecastWeatherRecord->owm_id = $currentWeatherRecord->owm_id;
                $forecastWeatherRecord->lat = $currentWeatherRecord->lat;
                $forecastWeatherRecord->lon = $currentWeatherRecord->lon;
                $forecastWeatherRecord->city = $currentWeatherRecord->city;
                $forecastWeatherRecord->country = $currentWeatherRecord->country;
                $forecastWeatherRecord->dt = Carbon::createFromTimestampUTC($forecastApiResponse['hourly'][$i]['dt'])->toDateTime();
                $forecastWeatherRecord->description = $forecastApiResponse['hourly'][$i]['weather'][0]['description'];
                $forecastWeatherRecord->icon = $forecastApiResponse['hourly'][$i]['weather'][0]['icon'];
                $forecastWeatherRecord->temp_current = $forecastApiResponse['hourly'][$i]['temp'];
                $forecastWeatherRecord->feels_like_current = $forecastApiResponse['hourly'][$i]['feels_like'];
                $forecastWeatherRecord->pressure = $forecastApiResponse['hourly'][$i]['pressure'];
                $forecastWeatherRecord->humidity = $forecastApiResponse['hourly'][$i]['humidity'];
                $forecastWeatherRecord->wind_speed = $forecastApiResponse['hourly'][$i]['wind_speed'];
                if (isset($forecastApiResponse['hourly'][$i]['rain']['1h'])) $forecastWeatherRecord->rain = $forecastApiResponse['hourly'][$i]['rain']['1h'];
                else $forecastWeatherRecord->rain = 0;
                $forecastWeatherRecord->type = 'hourly';
                $forecastWeatherRecord->save();
            }
        }     
        return $currentWeatherRecord;
    }
}
