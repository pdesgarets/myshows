<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class HomepageController extends Controller
{
    /**
     * @Route("/", name="homepage")
     * @Template("homepage/index.html.twig")
     */
    public function indexAction()
    {
        $shows = $this->getUser()->getShows();

        // replace this example code with whatever you need
        return array('shows' => $shows);
    }
}
