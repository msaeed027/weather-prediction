<?php

namespace Domain\Temperature\convertor;

use Domain\Temperature\Scale\TemperatureScaleInterface;

interface TemperatureConvertorInterface {
    public function convert(): TemperatureScaleInterface;
}