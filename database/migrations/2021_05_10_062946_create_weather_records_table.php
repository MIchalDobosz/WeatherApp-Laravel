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
            $table->string('city');
            $table->string('country');
            $table->string('description');
            $table->string('icon');
            $table->float('temp');
            $table->float('feels_like');
            $table->integer('pressure');
            $table->integer('humidity');
            $table->float('wind_speed');
            $table->timestamps();
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
