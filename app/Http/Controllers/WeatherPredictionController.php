<?php

namespace App\Http\Controllers;
use Domain\Weather\Services\WeatherPredictionService;

use Illuminate\Http\Request;
use Domain\Weather\Validators\GetWeatherPredictionRequest;
use Domain\Temperature\Scale\CelsiusScale;

class WeatherPredictionController extends Controller
{
    private $weatherPredictionService;

    public function __construct(WeatherPredictionService $weatherPredictionService) {
        $this->weatherPredictionService = $weatherPredictionService;
    }

    public function getWeather(Request $request, GetWeatherPredictionRequest $validator) {
        $errors = $validator->validate($request)->failed();
        if ($errors) {
            return response()->json(['message' => 'Validation error!', 'errors' => $errors], 422);
        }
        return response()->json($this->weatherPredictionService->getWeather($request->query('city'), $request->query('date'), $request->query('scale', CelsiusScale::SCALE_NAME)));
    }
}
