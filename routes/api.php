<?php

use Illuminate\Http\Request;
use Domain\Temperature\Scale\CelsiusScale;
use Domain\Temperature\Scale\FahrenheitScale;
use Domain\Temperature\Convertor\CelsiusToFahrenheit;
use Domain\Weather\Services\Partners\Partner2Service;
use Domain\Weather\Services\Partners\Partner1Service;
use Domain\Weather\Services\Partners\Partner3Service;
use Infrastructure\Communicator\TempPartner2Communicator;
use Infrastructure\HTTPHandler\HTTPHandler;
use Domain\Weather\Services\WeatherAggregatorService;
use GuzzleHttp\Client;
/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::get('weather', 'WeatherPredictionController@getWeather');