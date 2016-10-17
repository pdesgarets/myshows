<?php

namespace AppBundle\Controller;

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

        return array('shows' => $shows);
    }

}
