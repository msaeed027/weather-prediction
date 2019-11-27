<?php

namespace Domain\Temperature\Scale;

use Domain\Temperature\Scale\TemperatureScaleInterface;

abstract class BaseTemperatureScale implements TemperatureScaleInterface {
    protected $degree;

    public function __construct($degree) {
        $this->degree = $degree;
    }

    public function getDegree() {
        return $this->degree;
    }
    
    public abstract function getScaleName();
}