<?php

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
    $origLat1 = $request["first_city_latitude"];
    $origLat2 = $request["second_city_latitude"];
    $origLng1 = $request["first_city_longitude"];
    $origLng2 = $request["second_city_longitude"];
    $erro = "";
    $d = 0;
    try {
        $lat1 = $origLat1 * (M_PI / 180);
        $lat2 = $origLat2 * (M_PI / 180);
        $deltaLat = ($origLat2 - $origLat1) * (M_PI / 180);
        $deltaLng = ($origLng2 - $origLng1) * (M_PI / 180);

        $a = pow(sin($deltaLat / 2), 2) + cos($lat1) * cos($lat2) * pow(sin($deltaLng / 2), 2);
        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        $d = round(($R * $c) / 1e3, 2);
    } catch (Exception $e) {
        $erro = "Erro: " . $e->getMessage();
    }
    return view("main", [
        "distance" => "Distance: " . $d . "km",
        "first_city_latitude" => $origLat1,
        "first_city_longitude" => $origLng1,
        "second_city_latitude" => $origLat2,
        "second_city_longitude" => $origLng2,
        "error" => $erro
    ]);
});
