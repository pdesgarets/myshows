<?php

namespace AppBundle\Fetcher;

use AppBundle\API\RESTAPICaller;
use AppBundle\Entity\TVShow;

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
     * used to retrieve a list of shows from the api with a name matching the query
     *
     * @param string $query
     *
     * @return array
     *
     */
    public function getShows($query)
    {
        //call api to get shows list
        $shows = $this->RESTAPICaller->makeGetRequest('/search/shows?q=' . $query);

        //format result into tvshow entities
        foreach($shows as $show){
            $showsEntities[] = new TVShow($show->show->id, $show->show->name, strip_tags($show->show->summary), $show->show->image->original);
        }

        return $showsEntities;
    }

}