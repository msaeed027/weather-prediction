<?php

namespace Domain\Temperature\Convertor;

use  Domain\Temperature\Convertor\TemperatureConvertorInterface;
use Domain\Temperature\Scale\TemperatureScaleInterface;
use Domain\Temperature\Scale\CelsiusScale;
use Domain\Temperature\Scale\FahrenheitScale;

class FahrenheitToCelsius implements TemperatureConvertorInterface {
    private $scale;

    public function __construct(FahrenheitScale $fahrenheitScale) {
        $this->scale = $fahrenheitScale;
    }

    public function convert(): TemperatureScaleInterface {
        return new CelsiusScale(($this->scale->getDegree() - 32) * (5/9));
    }
}