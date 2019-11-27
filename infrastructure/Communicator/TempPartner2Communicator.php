<?php

namespace Infrastructure\Communicator;
use Infrastructure\HTTPHandler\HTTPHandler;

class TempPartner2Communicator {
    private $httpHandler;

    public function __construct(HTTPHandler $httpHandler) {
        $this->httpHandler = $httpHandler;
    }

    public function getWeather($city, $date) {
        $path = public_path(config('services.partner2.apis.get-weather'));
        return str_replace(['__CITY__', '__DATE__'], [$city, $date], file_get_contents($path));
        return file_get_contents(public_path(config('services.partner2.apis.get-weather')));
        // return $this->httpHandler->get(config('services.partner2.apis.get-weather'));
    }
}