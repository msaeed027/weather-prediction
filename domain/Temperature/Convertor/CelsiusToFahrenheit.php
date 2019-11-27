<?php

namespace Domain\Temperature\Convertor;

use  Domain\Temperature\Convertor\TemperatureConvertorInterface;
use Domain\Temperature\Scale\TemperatureScaleInterface;
use Domain\Temperature\Scale\CelsiusScale;
use Domain\Temperature\Scale\FahrenheitScale;

class CelsiusToFahrenheit implements TemperatureConvertorInterface {
    private $scale;

    public function __construct(CelsiusScale $celsiusScale) {
        $this->scale = $celsiusScale;
    }

    public function convert(): TemperatureScaleInterface {
        return new FahrenheitScale($this->scale->getDegree() * 9/5 + 32);
    }
}