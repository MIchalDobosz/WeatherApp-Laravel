<!DOCTYPE html>
<html lang="pl">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>Pogoda</title>
    </head>
    <body class="antialiased">
        <h1> Pogoda </h1>
        <br>

        @foreach ($weatherRecords as $weatherRecord)
            <div>
                <h2> Miasto: {{ $weatherRecord->city }} </h2>
                <h3> Pogoda: {{ $weatherRecord->description }} </h3>
                <h4> Temperatura: {{ $weatherRecord->temp }}°C </h4>
            </div> 
            <br>
        @endforeach
    </body>
</html>
