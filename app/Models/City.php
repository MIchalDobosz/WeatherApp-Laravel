<?php

namespace App\Models;

use App\Rules\CityAlreadyExists;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Request;
use Illuminate\Support\MessageBag;

class City extends Model
{
    use HasFactory;

    protected $table = 'cities';


    public static function saveCityFromForm($cityName): bool {
        //TODO: ??jeśli było już w bazie i zostało zaktualizowane niedawno, nie aktualizować??
        $city = new City();
        $city->name = $cityName;
        $weatherRecord = WeatherRecord::saveRecordsFromApi([$city]);
        if ($weatherRecord != null) {
            $city->name = $weatherRecord->city;
            $city->save();
            return true;
        } else return false;
    }
}
