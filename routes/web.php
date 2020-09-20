<?php

use App\SearchInfo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
 */

Route::get('/', function () {
    return view('main');
});

Route::post('/', function (Request $request) {
    $R = 6371e3;
    $data = $request->validate([
        'first_city_latitude' => 'required|numeric',
        'first_city_longitude' => 'required|numeric',
        'second_city_latitude' => 'required|numeric',
        'second_city_longitude' => 'required|numeric',
        'first_city_name' => 'string',
        'second_city_name' => 'string',
    ]);

    $dbData = [];

    $data['first_city_latlng'] =
        '(' .
        $data['first_city_latitude'] .
        ',' .
        $data['first_city_longitude'] .
        ')';

    $data['second_city_latlng'] =
        '(' .
        $data['second_city_latitude'] .
        ',' .
        $data['second_city_longitude'] .
        ')';

    $dbData['searched_coordinates'] =
        $data['first_city_latlng'] . ',' . $data['second_city_latlng'];

    $dbData['searched_cities'] =
        $data['first_city_name'] . ',' . $data['second_city_name'];

    $dbData['searched_cities'] = htmlspecialchars($dbData['searched_cities']);
    $dbData['visitor'] = $_SERVER['REMOTE_ADDR'];

    $origLat1 = $data['first_city_latitude'];
    $origLat2 = $data['second_city_latitude'];
    $origLng1 = $data['first_city_longitude'];
    $origLng2 = $data['second_city_longitude'];
    $d = 0;

    $lat1 = $origLat1 * (M_PI / 180);
    $lat2 = $origLat2 * (M_PI / 180);
    $deltaLat = ($origLat2 - $origLat1) * (M_PI / 180);
    $deltaLng = ($origLng2 - $origLng1) * (M_PI / 180);

    $a =
        pow(sin($deltaLat / 2), 2) +
        cos($lat1) * cos($lat2) * pow(sin($deltaLng / 2), 2);
    $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
    $d = round(($R * $c) / 1e3, 2);

    $dbData['distance'] = $d;
    // $searchInfo = tap(new \App\SearchInfo($dbData))->save();

    unset($data['first_city_latlng']);
    unset($data['second_city_latlng']);

    return view('main', [
        'distance' => 'Distance: ' . $d . 'km',
        'first_city_latitude' => $origLat1,
        'second_city_latitude' => $origLat2,
        'first_city_longitude' => $origLng1,
        'second_city_longitude' => $origLng2,
        'first_city_name' => $data['first_city_name'],
        'second_city_name' => $data['second_city_name'],
    ]);
});
