<?php

namespace Domain\Temperature\Scale;

class CelsiusScale extends BaseTemperatureScale {
    const SCALE_NAME = 'Celsius';

    public function getScaleName() {
        return self::SCALE_NAME;
    }
}