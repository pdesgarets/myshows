<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TVShow;
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
        $this->setAlertsForComingShows();

        // replace this example code with whatever you need
        return array('shows' => $shows);
    }

    private function setAlertsForComingShows()
    {
        $shows = $this->getUser()->getShows();
        $timing = new \DateInterval($this->getParameter('timing_alert'));
        $now = new \DateTime();
        $limit = (new \DateTime())->add($timing);
        /** @var TVShow $show */
        foreach ($shows as $show) {
            foreach ($this->get('myshows.fetcher.shows')->getEpisodes($show->getId()) as $episode) {
                $airDate = new \DateTime($episode->airstamp);
                $diff = $airDate->diff($now);
                if ($airDate->getTimestamp() > $now->getTimestamp() && $airDate->getTimestamp() < $limit->getTimestamp()) {
                    $this->addFlash(
                        'warning',
                        'Un nouvel épisode de <a href="' .
                        $this->generateUrl('tv_show_display', array('id' => $show->getId())) . '">' . $show->getName() .
                        '</a> sera disponible dans ' . ((int) $diff->format('%d') > 0 ? $diff->format('%d jours') : $diff->format('%h heures')) . ' !'
                    );
                    break;
                }
            }
        }
    }
}
