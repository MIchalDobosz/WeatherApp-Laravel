<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWeatherRecordsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weather_records', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('owm_id');
            $table->float('lat');
            $table->float('lon');
            $table->string('city');
            $table->string('country');
            $table->dateTime('dt');
            $table->string('description');
            $table->string('icon');
            $table->float('temp_current')->nullable();
            $table->float('temp_day')->nullable();
            $table->float('temp_night')->nullable();
            $table->float('feels_like_current')->nullable();
            $table->float('feels_like_day')->nullable();
            $table->float('feels_like_night')->nullable();
            $table->integer('pressure');
            $table->integer('humidity');
            $table->float('wind_speed');
            $table->string('type');
            $table->Timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weather_records');
    }
}
