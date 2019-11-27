<?php

namespace Domain\Temperature\Convertor;
use Domain\Temperature\Scale\TemperatureScaleInterface;
use Exception;

class TemperatureConvertorFactory {
    public static function make(TemperatureScaleInterface $temperatureScale, $toScaleName): TemperatureScaleInterface {
        $fromScaleName = $temperatureScale->getScaleName();
        if ($fromScaleName == $toScaleName) {
            return $temperatureScale;
        }
        $convetorClass = "Domain\\Temperature\\Convertor\\${fromScaleName}To${toScaleName}";
        
        if (class_exists($convetorClass)) {
            return (new $convetorClass($temperatureScale))->convert();
        } else {
            throw new Exception('Not supported conversion between provided scales!');
        }
    }
}