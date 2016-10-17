<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;

class SearchController extends Controller
{
    /**
     * @Route("/results")
     * @Template("/search/results.html.twig")
     */
    public function resultsAction()
    {
        $shows = $this->get('myshows.fetcher.shows')->getShows('friends');

        // replace this example code with whatever you need
        return array('shows' => $shows);
    }

}
