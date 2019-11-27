<?php

namespace Infrastructure\HTTPHandler;
use GuzzleHttp\Client;

class HTTPHandler {
    private $client;

    public function __construct() {
        // $this->client = new Client();
    }

    public function get($url) {
        return file_get_contents($url); // $this->client->get($url);
    }

    // other methods (post, put, ...) should be added but we will not use them in this task
    // so i excluded them
}