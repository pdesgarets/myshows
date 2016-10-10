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
        $shows = json_decode($this->apiclient->get('/schedule?country=US&date=2014-01-12')->getBody()->getContents());
        return $shows;
    }
}