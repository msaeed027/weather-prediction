<?php

namespace Domain\Weather\Services\Partners;
use Domain\Weather\Services\Partners\PartnerServiceInterface;
use Infrastructure\Communicator\TempPartner1Communicator;
use \DateTime;
use Domain\Temperature\Scale\TemperatureScaleFactory;
use Domain\Weather\Entities\TempPartnerResponse;

class Partner1Service implements PartnerServiceInterface {
    private $tempPartner1Communicator;

    public function __construct(TempPartner1Communicator $tempPartner1Communicator) {
        $this->tempPartner1Communicator = $tempPartner1Communicator;
    }

    public function getWeather($city, $date): TempPartnerResponse {
        $partnerResponse = explode(PHP_EOL, trim($this->tempPartner1Communicator->getWeather($city, $date)));
        $csvLinesArray = [];
        foreach ($partnerResponse as $csvLine) {
            $csvLineArray = str_getcsv($csvLine);
            $csvLinesArray[] = $csvLineArray;
        }
        
        array_walk($csvLinesArray, function(&$csvLineArray) use ($csvLinesArray) {
            $csvLineArray = array_combine($csvLinesArray[0], $csvLineArray);
        });
        array_shift($csvLinesArray);

        $scaleName = $csvLinesArray[0]['-scale'];
        $city = $csvLinesArray[0]['city'];
        $date = DateTime::createFromFormat('Ymd', $csvLinesArray[0]['date']);
        $outputPredictions = [];
        foreach ($csvLinesArray as $i => $prediction) {
            $value = $prediction['prediction__value'];
            $scale = TemperatureScaleFactory::make($scaleName, $value);
            $outputPredictions[$prediction['prediction__time']] = $scale;
        }
        return new TempPartnerResponse($scaleName, $city, $date, $outputPredictions);
    }
}