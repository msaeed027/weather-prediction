<?php

namespace Domain\Temperature\Scale;

class FahrenheitScale extends BaseTemperatureScale {
    const SCALE_NAME = 'Fahrenheit';

    public function getScaleName() {
        return self::SCALE_NAME;
    }
}