<?php

namespace AppBundle\API;


use GuzzleHttp\Client;

class RESTAPICaller
{
    /**
     * @var Client
     */
    private $apiclient;


    public function __construct(Client $clientGuzzle )
    {
        $this->apiclient = $clientGuzzle;
    }

    public function makeGetRequest($url)
    {
        $response = json_decode($this->apiclient->get($url)->getBody()->getContents());
        return $response;
    }
}