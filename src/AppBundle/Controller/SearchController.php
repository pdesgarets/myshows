<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TVShow;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\Request;

/**
 * Class SearchController
 * @Route("/search")
 */
class SearchController extends Controller
{
    /**
     * @Route("/results", name="search_results")
     * @Template("/search/results.html.twig")
     * @param Request $request
     * @return array
     */
    public function resultsAction(Request $request)
    {
        $query = $request->get('q');
        $shows = $this->get('myshows.fetcher.shows')->getShows($query);
        $favoriteIds = array();

        $myShows = $this->getUser()->getShows();
        $myShowsId = array();
        /** @var TVShow $show */
        foreach ($myShows as $show) {
            $myShowsId[] = $show->getId();
        }
        foreach ($shows as $show) {
            $id = $show->getId();
            $favoriteIds[$id] = (in_array($id, $myShowsId)) ? true : false;
        }

        return array(
            'favShowsId' => $favoriteIds,
            'shows' => $shows,
            'query' => $query);
    }

}
