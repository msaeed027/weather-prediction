<?php

namespace Domain\Weather\Services;
use Domain\Weather\Services\WeatherAggregatorService;
use LaravelRedis;
use Domain\Temperature\Convertor\TemperatureConvertorFactory;
use Exception;

class WeatherPredictionService {
    private $weatherAggregatorService;
    public function __construct(WeatherAggregatorService $weatherAggregatorService) {
        $this->weatherAggregatorService = $weatherAggregatorService;
    }

    public function changeScale($aggregatedTemperatures, $toScaleName) {
        $toScaleName = ucfirst(strtolower($toScaleName));
        if ($aggregatedTemperatures['scale'] != $toScaleName) {
            foreach($aggregatedTemperatures['predictions'] as $time => $prediction) {
                $fromScaleName = $aggregatedTemperatures['scale'];
                $fromScale = "Domain\\Temperature\\Scale\\${fromScaleName}Scale";
                try {
                    $aggregatedTemperatures['predictions'][$time] = TemperatureConvertorFactory::make(new $fromScale($prediction), $toScaleName)->getDegree();
                } catch (Exception $e) {
                    throw new Exception('Not supported scale!');
                }
            }
            $aggregatedTemperatures['scale'] = $toScaleName;
        }
        return $aggregatedTemperatures;
    }

    public function getWeather($city, $date, $scaleName, $format = 'json') {
        $aggregatedTemperatures = [];
        $cache = LaravelRedis::get("${city}:${date}");
        if ($cache) {
            $aggregatedTemperatures = json_decode($cache, true);
        } else {
            $aggregatedTemperatures = $this->weatherAggregatorService->aggregateTemperatures($city, $date)->toArray();
            LaravelRedis::set("${city}:${date}", json_encode($aggregatedTemperatures), 'EX', 60);
        }
        
        return $this->changeScale($aggregatedTemperatures, $scaleName);
    }
}