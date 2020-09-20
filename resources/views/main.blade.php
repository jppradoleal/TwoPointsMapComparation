@extends('layouts.principal')
@section('title', 'Distance Calculation')
@section('head_links')
<link rel="stylesheet" href="{{ secure_asset('css/app.css') }}">
@endsection
@section('content')
<form method="POST">
    @csrf
    <fieldset id="latlong">
        <fieldset>
            <input name="first_city_name" class="cityName" id="first_city_name" value="{{$first_city_name ?? 'First City'}}" readonly>
            <label for="first_city_latitude">Latitude</label>
            <input class="coordInputs" id="first_city_latitude" name="first_city_latitude" value="{{ $first_city_latitude ?? '' }}" />
            <label for="first_city_longitude">Longitude</label>
            <input class="coordInputs" id="first_city_longitude" name="first_city_longitude" value="{{ $first_city_longitude ?? '' }}" />
        </fieldset>
        <hr>
        <fieldset>
            <input name="second_city_name" class="cityName" id="second_city_name" value="{{$second_city_name ?? 'Second City'}}" readonly>
            <label for="second_city_latitude">Latitude</label>
            <input class="coordInputs" id="second_city_latitude" name="second_city_latitude" value="{{ $second_city_latitude ?? '' }}" />
            <label for="second_city_longitude">Longitude</label>
            <input class="coordInputs" id="second_city_longitude" name="second_city_longitude" value="{{ $second_city_longitude ?? '' }}" />
        </fieldset>
        <button>Submit</button>
        <p style="font-size: 1.2rem">{{$distance ?? "Distance: 0km"}}</p>
        @if ($errors)
        <p style="color:red;border:none">{{$errors}}</p>
        @endif
    </fieldset>
</form>

<div id="map"></div>
<script src="{{ secure_asset('js/app.js') }}"></script>
@endsection