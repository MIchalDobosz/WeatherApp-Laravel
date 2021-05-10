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
                <form action="/delete" method="post">
                    @csrf
                    <input type="text" name="cityName" value="{{ $weatherRecord->city }}" hidden>
                    <input type="submit" value="Usuń">
                </form>
            </div> 
            <br>
        @endforeach

        @if (count($weatherRecords) < 10)
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
    </body>
</html>
