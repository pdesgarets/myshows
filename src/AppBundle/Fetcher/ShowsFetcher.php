<?php

namespace AppBundle\Fetcher;

use AppBundle\API\RESTAPICaller;

class ShowsFetcher
{

    /**
     * @var RESTAPICaller
     */
    private $RESTAPICaller;

    /**
     * @param RESTAPICaller $RESTAPICaller
     */
    public function __construct(RESTAPICaller $RESTAPICaller)
    {
        $this->RESTAPICaller = $RESTAPICaller;
    }

    /**
     * @return string
     */
    public function getShows()
    {
        // stuff
        $shows = $this->RESTAPICaller->makeGetRequest('/shows');

        //other stuff

        return $shows;
    }

    
}