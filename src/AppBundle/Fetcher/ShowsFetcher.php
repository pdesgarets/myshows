<?php

namespace AppBundle\Fetcher;

use AppBundle\API\RESTAPICaller;
use AppBundle\Entity\TVShow;
use GuzzleHttp\Exception\ClientException;

class ShowsFetcher
{

    /**
     * @var RESTAPICaller
     */
    private $RESTAPICaller;
    private $placeholderUrl;

    /**
     * @param RESTAPICaller $RESTAPICaller
     * @param string $placeholderUrl
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
                $showsEntities[] = $this->buildShow($show->show);
            }

            return $showsEntities;
        }
    }

    /**
     * Used to retrieve a unique show
     * @param $id
     * @return TVShow
     */
    public function getShow($id)
    {
        try {
            $show = $this->RESTAPICaller->makeGetRequest('/shows/' . $id);
        } catch (ClientException $e) {
            return null;
        }

        return $this->buildShow($show);
    }

    /**
     * @param array $objectShow from the API
     * @return TVShow
     */
    private function buildShow($objectShow)
    {
        return new TVShow($objectShow->id, $objectShow->name, strip_tags($objectShow->summary), $objectShow->image ? $objectShow->image->original : $this->placeholderUrl);
    }

    public function getNextEpisodes($id)
    {
        return $this->RESTAPICaller->makeGetRequest('/shows/' . $id . '/episodes');
    }

}