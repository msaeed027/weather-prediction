<?php

namespace Domain\Temperature\Scale;
use Exception;

class TemperatureScaleFactory {
    public static function make($scaleName, $degree) {
        $scaleName = ucfirst(strtolower($scaleName));
        $scaleClass = "Domain\\Temperature\\Scale\\${scaleName}Scale";
        if (class_exists($scaleClass)) {
            return new $scaleClass($degree);
        } else {
            throw new Exception('Not supported scale!');
        }
    }
}
