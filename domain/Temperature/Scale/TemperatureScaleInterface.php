<?php

namespace Domain\Temperature\Scale;

interface TemperatureScaleInterface {
    public function getDegree();
    public function getScaleName();
}