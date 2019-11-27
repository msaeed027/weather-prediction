<?php

namespace Domain\Weather\Services\Partners;

use Domain\Weather\Entities\TempPartnerResponse;

interface PartnerServiceInterface {
    public function getWeather($city, $date): TempPartnerResponse;
}