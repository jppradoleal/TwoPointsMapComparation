<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@300;500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">

    <script src="https://js.api.here.com/v3/3.1/mapsjs-core.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-service.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-mapevents.js" type="text/javascript" charset="utf-8"></script>
    <script src="https://js.api.here.com/v3/3.1/mapsjs-ui.js" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" type="text/css" href="https://js.api.here.com/v3/3.1/mapsjs-ui.css" />
</head>

<body>

    <form method="POST">
        @csrf
        <fieldset id="latlong">
            <fieldset>
                <p>First City</p>
                <label for="first_city_latitude">Latitude</label>
                <input class="coordInputs" id="first_city_latitude" name="first_city_latitude" value="{{ $first_city_latitude ?? '' }}" />
                <label for="first_city_longitude">Longitude</label>
                <input class="coordInputs" id="first_city_longitude" name="first_city_longitude" value="{{ $first_city_longitude ?? '' }}" />
            </fieldset>
            <hr>
            <fieldset>
                <p>Second City</p>
                <label for="second_city_latitude">Latitude</label>
                <input class="coordInputs" id="second_city_latitude" name="second_city_latitude" value="{{ $second_city_latitude ?? '' }}" />
                <label for="second_city_longitude">Longitude</label>
                <input class="coordInputs" id="second_city_longitude" name="second_city_longitude" value="{{ $second_city_longitude ?? '' }}" />
            </fieldset>
            <button>Submit</button>
            <p>{{$distance ?? ""}}</p>
            @if ($error)
            <p style="color:red">{{$error}}</p>
            @endif
        </fieldset>
    </form>

    <div id="map"></div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>

</html>