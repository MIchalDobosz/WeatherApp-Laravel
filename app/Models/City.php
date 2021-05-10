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
        $city = new City();
        $city->name = $cityName;
        if (WeatherRecord::saveRecordsFromApi([$city]) == true) {
            $city->save();
            return true;
        } else return false;
    }
}
