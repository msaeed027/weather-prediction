<?php

namespace Domain\Weather\Services\Partners;
use Domain\Weather\Services\Partners\PartnerServiceInterface;
use Infrastructure\Communicator\TempPartner3Communicator;
use \SimpleXMLElement;
use \DateTime;
use Domain\Temperature\Scale\TemperatureScaleFactory;
use Domain\Weather\Entities\TempPartnerResponse;

class Partner3Service implements PartnerServiceInterface {
    private $tempPartner3Communicator;

    public function __construct(TempPartner3Communicator $tempPartner3Communicator) {
        $this->tempPartner3Communicator = $tempPartner3Communicator;
    }

    public function getWeather($city, $date): TempPartnerResponse {
        $partnerResponse = new SimpleXMLElement($this->tempPartner3Communicator->getWeather($city, $date));
        $scaleName = (string) $partnerResponse->attributes()->scale;
        $city = (string) $partnerResponse->city;
        $date = DateTime::createFromFormat('Ymd', (string) $partnerResponse->date);
        $xmlObjectPredictions = $partnerResponse->prediction;
        $outputpredictions = [];
        foreach ($xmlObjectPredictions as $i => $prediction) {
            $value = (string) $prediction->value;
            $scale = TemperatureScaleFactory::make($scaleName, $value);
            $outputpredictions[(string) $prediction->time] = $scale;
        }

        return new TempPartnerResponse($scaleName, $city, $date, $outputpredictions);
    }
}