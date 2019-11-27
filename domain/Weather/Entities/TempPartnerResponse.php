<?php

namespace Domain\Weather\Entities;

class TempPartnerResponse {
    public $scale, $city, $date, $predictions;

    public function __construct($scale, $city, $date, $predictions) {
        $this->scale = $scale;
        $this->city = $city;
        $this->date = $date;
        $this->predictions = $predictions;
    }

    public function toArray() {
        $predictions = [];
        foreach ($this->predictions as $time => $scale) {
            $predictions[$time] = $scale->getDegree();
        }
        return [
            'scale' => $this->scale,
            'city' => $this->city,
            'date' => $this->date,
            'predictions' => $predictions
        ];
    }

    public function __tostring() {
        return json_encode($this->toArray());
    }
}