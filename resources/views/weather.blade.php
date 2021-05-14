<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pogoda</title>
        <!-- Charting library -->
        <script src="https://unpkg.com/chart.js@2.9.3/dist/Chart.min.js"></script>
        <!-- Chartisan -->
        <script src="https://unpkg.com/@chartisan/chartjs@^2.1.0/dist/chartisan_chartjs.umd.js"></script>
        <!-- Bootswatch -->
        <link rel="stylesheet" href="css/bootstrap.css">
    </head>
    </head>
    <body>
        <!-- navbar -->
        <div class="navbar navbar-expand-lg sticky-top navbar-dark bg-primary">
            <div class="container">
                <h1 class="navbar-brand">Aplikacja Pogodowa</h1>
                <div class="navbar-colapse" id="navbarColor01">
                    @if($errors->any())
                        <form class="d-flex" action="/addCity" method="post">
                            @csrf
                            <input class="form-control is-invalid me-sm-2" type="text" id="cityNameInput" name="cityName" placeholder="{{ $errors->first() }}" style="width: 210px; required">
                            <button class="btn btn-secondary my-2 my-sm-0" type="submit">Dodaj</button>
                        </form>
                        @else
                            @if (count($currentWeatherRecords) < 10)
                            <form class="d-flex" action="/addCity" method="post">
                                @csrf
                                <input class="form-control me-sm-2" type="text" id="cityNameInput" name="cityName" placeholder="Dodaj miasto" style="width: 210px; required">
                                <button class="btn btn-secondary my-2 my-sm-0" type="submit">Dodaj</button>
                            </form>
                            @else
                                <form class="d-flex" action="#" method="post">
                                    @csrf
                                    <input class="form-control me-sm-2" type="text" id="cityNameInput" name="cityName" placeholder="Obserwujesz już 10 miast" style="width: 210px;" required disabled>
                                    <button class="btn btn-secondary my-2 my-sm-0" type="submit" disabled>Dodaj</button>
                                </form>
                            @endif
                    @endif
                </div>
            </div>
        </div>
        <div class="container mt-5">       
            @php
                $i = 0;
            @endphp
            @foreach ($currentWeatherRecords as $currentWeatherRecord)
                <div class="city-record-section bg-secondary p-3 pb-0 rounded">
                    <div class="page-header">
                        <div class="row">
                            <div class="col-lg-3">
                                <h1> {{ $currentWeatherRecord->city }} </h1>
                                <p> {{ Carbon\Carbon::parse($currentWeatherRecord->dt)->format('d-m-Y') }}
                                    {{ Carbon\Carbon::parse($currentWeatherRecord->dt)->format('h') + 2 }}:{{ Carbon\Carbon::parse($currentWeatherRecord->dt)->format('i') }}
                                </p>
                                <p> 
                                    {{ $currentWeatherRecord->description }}
                                </p>
                            </div>
                            <div class="col-lg-6">
                                <div class="row">
                                    <div class="col-lg-12 d-flex justify-content-center">
                                        <button class="btn btn-primary btn-sm" id="hourlyChartButton{{ $currentWeatherRecord->id }}" onclick="showHourlyChart({{ $currentWeatherRecord->id }})">Temperatura 24h</button>
                                        <button class="btn btn-primary btn-sm" id="dailyChartButton{{ $currentWeatherRecord->id }}" onclick="showDailyChart({{ $currentWeatherRecord->id }})">Temperatura tydzień</button>
                                        <button class="btn btn-primary btn-sm" id="hourlyRainChartButton{{ $currentWeatherRecord->id }}" onclick="showHourlyRainChart({{ $currentWeatherRecord->id }})">Opady 24h</button>
                                        <button class="btn btn-primary btn-sm" id="dailyRainChartButton{{ $currentWeatherRecord->id }}" onclick="showDailyRainChart({{ $currentWeatherRecord->id }})">Opady tydzień</button>
                                    </div>
                                </div>
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div id="hourlyChart{{$currentWeatherRecord->id}}" style="display: block; height: 180px; width: 100%"></div>
                                        <script>
                                            const hourlyChart{{ $currentWeatherRecord->id }} = new Chartisan({
                                                el: '#hourlyChart{{ $currentWeatherRecord->id }}',
                                                data: {!! $hourlyCharts[$i] !!},
                                                hooks: new ChartisanHooks()
                                                    .colors(['#ECC94B', '#4299E1'])
                                                    .borderColors(['#ECC94B'])
                                                    .responsive()
                                                    .legend(false)
                                                    .stepSize(2)
                                                    .datasets([{ type: 'line', fill: false }]),
                                            })
                                        </script>
                                        <div id="dailyChart{{$currentWeatherRecord->id}}" style="display: none; height: 180px; width: 100%"></div>
                                        <script>
                                            const dailyChart{{ $currentWeatherRecord->id }} = new Chartisan({
                                                el: '#dailyChart{{ $currentWeatherRecord->id }}',
                                                data: {!! $dailyCharts[$i] !!},
                                                hooks: new ChartisanHooks()
                                                    .colors(['#ECC94B', '#4299E1'])
                                                    .borderColors(['#ECC94B'])
                                                    .responsive()
                                                    .legend(false)
                                                    .stepSize(2)
                                                    .datasets([{ type: 'line', fill: false }]),
                                            })
                                        </script>
                                        <div id="dailyRainChart{{$currentWeatherRecord->id}}" style="display: none; height: 180px; width: 100%"></div>
                                        <script>
                                            const dailyRainChart{{ $currentWeatherRecord->id }} = new Chartisan({
                                                el: '#dailyRainChart{{ $currentWeatherRecord->id }}',
                                                data: {!! $dailyRainCharts[$i] !!},
                                                hooks: new ChartisanHooks()
                                                    .colors(['#3232ffB', '#4299E1'])
                                                    .borderColors(['#3232ff'])
                                                    .responsive()
                                                    .legend(false)
                                                    .beginAtZero(true)
                                                    .stepSize(2)
                                                    .datasets([{ type: 'line', fill: false }]),
                                            })
                                        </script>
                                        <div id="hourlyRainChart{{$currentWeatherRecord->id}}" style="display: none; height: 180px; width: 100%"></div>
                                        <script>
                                            const hourlyRainChart{{ $currentWeatherRecord->id }} = new Chartisan({
                                                el: '#hourlyRainChart{{ $currentWeatherRecord->id }}',
                                                data: {!! $hourlyRainCharts[$i] !!},
                                                hooks: new ChartisanHooks()
                                                    .colors(['#3232ffB', '#4299E1'])
                                                    .borderColors(['#3232ff'])
                                                    .responsive()
                                                    .legend(false)
                                                    .beginAtZero(true)
                                                    .stepSize(2)
                                                    .datasets([{ type: 'line', fill: false }]),
                                            })
                                        </script>
                                    </div>
                                    <div class="row">
                                        <div class="col-lg-12 d-flex justify-content-center pt-2">
                                            <button class="btn btn-primary btn-sm" id="showMoreButton{{ $currentWeatherRecord->id }}" onclick="showDetails({{ $currentWeatherRecord->id }})">Pokaż więcej</button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="col-lg-1">
                                <img id="icon" style="width: 100%;" src="http://openweathermap.org/img/w/{{ $currentWeatherRecord->icon }}.png">
                            </div>
                            <div class="col-lg-2 pt-2">
                                <h1 class="display-6"> {{ $currentWeatherRecord->temp_current }}°C </h1>
                                <p> Odczuwalna: {{ $currentWeatherRecord->feels_like_current }}°C </p>
                                <p> Ciśnienie: {{ $currentWeatherRecord->pressure }}hPa </p>
                                <form action="/delete" method="post">
                                    @csrf
                                    <input type="text" name="cityName" value="{{ $currentWeatherRecord->city }}" hidden>
                                    <input class="btn btn-warning" type="submit" value="Usuń">
                                </form>
                            </div>
                        </div>
                    </div>
                    <div id="showMore{{ $currentWeatherRecord->id }}" style="display: none;">
                        <div class="row">
                            <div class="col-lg-12 d-flex justify-content-center">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th class="col-2 text-center"> Temperatura </th>
                                            <th class="col-2 text-center"> Temperatura odczuwalna </th>
                                            <th class="col-2 text-center"> Ciśnienie </th>
                                            <th class="col-2 text-center"> Wilgotność </th>
                                            <th class="col-2 text-center"> Szybkość wiatru </th>
                                            <th class="col-2 text-center"> Gęstość opadów </th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <td class="col-2 text-center"> {{ $currentWeatherRecord->temp_current }}°C </td>
                                            <td class="col-2 text-center"> {{ $currentWeatherRecord->feels_like_current }}°C </td>
                                            <td class="col-2 text-center"> {{ $currentWeatherRecord->pressure }}hPa </td>
                                            <td class="col-2 text-center"> {{ $currentWeatherRecord->humidity }}% </td>
                                            <td class="col-2 text-center"> {{ $currentWeatherRecord->wind_speed }}m/s </td>
                                            <td class="col-2 text-center"> {{ $currentWeatherRecord->rain }}l/m2 </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div> 
                <br>
                <br>
                @php
                    $i++;
                @endphp
            @endforeach
            </div>
            
        </div>
        <script src="js/script.js"></script>
    </body>
</html>
