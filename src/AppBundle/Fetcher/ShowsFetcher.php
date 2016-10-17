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
    private $placeholderUrl;

    /**
     * @param RESTAPICaller $RESTAPICaller
     */
    public function __construct(RESTAPICaller $RESTAPICaller, $placeholderUrl)
    {
        $this->RESTAPICaller = $RESTAPICaller;
        $this->placeholderUrl = $placeholderUrl;
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

        if (empty($shows)) {
            return array();
        } else {
            //format result into tvshow entities
            foreach ($shows as $show) {
                $showsEntities[] = new TVShow($show->show->id, $show->show->name, strip_tags($show->show->summary), $show->show->image ? $show->show->image->original : $this->placeholderUrl);
            }

            return $showsEntities;
        }
    }

}