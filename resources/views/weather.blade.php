<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pogoda</title>
    </head>
    <body class="antialiased">
        <div>
            <div>
                <h1> Pogoda </h1>
            </div>
            <br>

            @php
                $i = 0;
            @endphp
            @foreach ($currentWeatherRecords as $currentWeatherRecord)
                <div>
                    <h2> Miasto: {{ $currentWeatherRecord->city }} </h2>
                    <h3> Pogoda: {{ $currentWeatherRecord->description }} </h3>
                    <h4> Temperatura: {{ $currentWeatherRecord->temp_current }}°C </h4>
                    <form action="/delete" method="post">
                        @csrf
                        <input type="text" name="cityName" value="{{ $currentWeatherRecord->city }}" hidden>
                        <input type="submit" value="Usuń">
                    </form>
                    <button id="showMoreButton{{ $currentWeatherRecord->id }}" onclick="showDetails({{ $currentWeatherRecord->id }})">Pokaż więcej</button>
                    <div id="showMoreDiv{{ $currentWeatherRecord->id }}" style="display: none;">
                        <h4> Temperatura odczuwalna: {{ $currentWeatherRecord->feels_like_current }}°C </h4>
                        <h4> Ciśnienie: {{ $currentWeatherRecord->pressure }}hPa </h4>
                        <h4> Wilgotność: {{ $currentWeatherRecord->humidity }}% </h4>
                        <h4> Wiatr: {{ $currentWeatherRecord->temp_current }}m/s </h4>
                        <button id="dailyForecastDayButton{{ $currentWeatherRecord->id }}" onclick="showDailyForecastDay({{ $currentWeatherRecord->id }})">Prognoza na tydzień (dzień)</button>
                        <button id="dailyForecastNightButton{{ $currentWeatherRecord->id }}" onclick="showDailyForecastNight({{ $currentWeatherRecord->id }})">Prognoza na tydzień (noc)</button>
                        <button id="hourlyForecastButton{{ $currentWeatherRecord->id }}" onclick="showHourlyForecast({{ $currentWeatherRecord->id }})">Prognoza na 24 godziny</button>
                        <div id="dailyForecastDayDiv{{ $currentWeatherRecord->id }}">
                            <table>
                                <thead>
                                    <td> <b>Data</b> </td>
                                    <td> <b>Pogoda </td>
                                    <td> <b>Temperatura </td>
                                </thead>
                                <tbody>
                                    @foreach ($dailyWeatherRecords[$i] as $dailyWeatherRecord)
                                        @if ($dailyWeatherRecord->city == $currentWeatherRecord->city)
                                        <tr>
                                            <td> {{ Carbon\Carbon::parse($dailyWeatherRecord->dt)->format('d-m-Y') }} </td>
                                            <td> {{ $dailyWeatherRecord->description }} </td>
                                            <td> {{ $dailyWeatherRecord->temp_day }} </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="dailyForecastNightDiv{{ $currentWeatherRecord->id }}" style="display: none;">
                            <table>
                                <thead>
                                    <td> <b>Data</b> </td>
                                    <td> <b>Pogoda </td>
                                    <td> <b>Temperatura </td>
                                </thead>
                                <tbody>
                                    @foreach ($dailyWeatherRecords[$i] as $dailyWeatherRecord)
                                        @if ($dailyWeatherRecord->city == $currentWeatherRecord->city)
                                        <tr>
                                            <td> {{ Carbon\Carbon::parse($dailyWeatherRecord->dt)->format('d-m-Y') }} </td>
                                            <td> {{ $dailyWeatherRecord->description }} </td>
                                            <td> {{ $dailyWeatherRecord->temp_night }} </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                        <div id="hourlyForecastDiv{{ $currentWeatherRecord->id }}" style="display: none;">
                            <table>
                                <thead>
                                    <td> <b>Godzina</b> </td>
                                    <td> <b>Pogoda</b> </td>
                                    <td> <b>Temperatura</b> </td>
                                </thead>
                                <tbody>
                                    @foreach ($hourlyWeatherRecords[$i] as $hourlyWeatherRecord)
                                        @if ($hourlyWeatherRecord->city == $hourlyWeatherRecord->city)
                                        <tr>
                                            <td> {{ Carbon\Carbon::parse($hourlyWeatherRecord->dt)->format('H:i:s') }} </td>
                                            <td> {{ $hourlyWeatherRecord->description }} </td>
                                            <td> {{ $hourlyWeatherRecord->temp_current }} </td>
                                        </tr>
                                        @endif
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div> 
                <br>
                <br>
                @php
                    $i++;
                @endphp
            @endforeach

            @if (count($currentWeatherRecords) < 10)
                <br>
                <div>
                    <h2> Obserwuj nowe miasto: </h2>
                    <form action="/addCity" method="post">
                        @csrf
                        <label id="cityNameLabel" for="cityNameInput">Miasto:</label>
                        <input id="cityNameInput" type="text" name="cityName" required>
                        <input type="submit" value="Dodaj">
                    </form>
                    {{ $errors->first() }}
                </div>
            @endif
        </div>
        <script src="js/script.js"></script>
    </body>
</html>
