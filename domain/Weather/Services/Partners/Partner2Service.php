<?php

namespace Domain\Weather\Services\Partners;
use Domain\Weather\Services\Partners\PartnerServiceInterface;
use Infrastructure\Communicator\TempPartner2Communicator;
use \DateTime;
use Domain\Temperature\Scale\TemperatureScaleFactory;
use Domain\Weather\Entities\TempPartnerResponse;

class Partner2Service implements PartnerServiceInterface {
    private $tempPartner2Communicator;

    public function __construct(TempPartner2Communicator $tempPartner2Communicator) {
        $this->tempPartner2Communicator = $tempPartner2Communicator;
    }

    public function getWeather($city, $date): TempPartnerResponse {
        $partnerResponse = json_decode($this->tempPartner2Communicator->getWeather($city, $date), true);
        $scaleName = $partnerResponse['predictions']['-scale'];
        $city = $partnerResponse['predictions']['city'];
        $date = DateTime::createFromFormat('Ymd', $partnerResponse['predictions']['date']);
        $predictions = $partnerResponse['predictions']['prediction'];
        $outputPredictions = [];
        foreach ($predictions as $i => $prediction) {
            $value = $prediction['value'];
            $scale = TemperatureScaleFactory::make($scaleName, $value);
            $outputPredictions[$prediction['time']] = $scale;
        }
        return new TempPartnerResponse($scaleName, $city, $date, $outputPredictions);
    }
}