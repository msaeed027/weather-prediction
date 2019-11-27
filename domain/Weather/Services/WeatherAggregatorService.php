<?php

namespace Domain\Weather\Services;

use Domain\Weather\Entities\TempPartnerResponse;
use Domain\Temperature\Scale\CelsiusScale;
use Domain\Temperature\Convertor\TemperatureConvertorFactory;
use Domain\Weather\Services\Partners\PartnerServiceInterface;

class WeatherAggregatorService {

    private $tempPartners = [];

    public function __construct() {
        $this->tempPartners = config('temperature-partners.supported-partners');
    }
    
    public function aggregateTemperatures($city, $date) {
        $partnerPredictions = [];
        foreach($this->tempPartners as  $tempPartnerService) {
            $instance = app($tempPartnerService);
            if ($instance instanceof PartnerServiceInterface) {
                $partnerPredictions[] =$instance->getWeather($city, str_replace('-', '', $date));
            }
        }
        
        $aggregatedpredictions = [];
        foreach ($partnerPredictions as $partnerPrediction) {
            foreach ($partnerPrediction->predictions as $time => $scale) {
                $scale = TemperatureConvertorFactory::make($scale, CelsiusScale::SCALE_NAME);
                if (isset($aggregatedpredictions[$time])) {
                    $aggregatedpredictions[$time] = ['scale' => $aggregatedpredictions[$time]['scale'] + $scale->getDegree(), 'count' => $aggregatedpredictions[$time]['count'] + 1];
                } else {
                    $aggregatedpredictions[$time] = ['scale' => $scale->getDegree(), 'count' => 1];
                }
                
            }
        }

        foreach($aggregatedpredictions as $time => $aggregatedPredicition) {
            $aggregatedpredictions[$time] = new CelsiusScale((int) round($aggregatedPredicition['scale'] / $aggregatedPredicition['count']));
        }

        return new TempPartnerResponse(CelsiusScale::SCALE_NAME, $city, $date, $aggregatedpredictions);
    }
}