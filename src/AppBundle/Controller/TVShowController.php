<?php

namespace AppBundle\Controller;

use AppBundle\Entity\TVShow;
use Doctrine\Common\Collections\Collection;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

/**
 * Class TVShowController
 * @Route("/tv_show")
 */
class TVShowController extends Controller
{
    /**
     * @Route("/{id}", name="tv_show_display")
     * @Template("/tv_show/display.index.html.twig")
     * @param int $id
     * @return array
     */
    public function displayAction($id)
    {
        $show = $this->getShow($id);
        /** @var Collection $favoriteShows */
        $favoriteShows = $this->getUser()->getShows();
        $nextEpisodes = $this->get('myshows.fetcher.shows')->getNextEpisodes($id);

        return array(
            'show' => $show,
            'nextEpisodes' => $nextEpisodes,
            'isFavorite' => $favoriteShows->contains($show)
        );
    }

    /**
     * @Route("/addToFav/{id}", name="tv_show_add_to_fav")
     * @param int $id
     * @return RedirectResponse
     */
    public function addToFavoritesAction($id)
    {
        $show = $this->getShow($id);
        if ($this->getUser()->getShows()->contains($show)) {
            $this->addFlash('warning', 'Série déjà favorite');
        } else {
            $this->getUser()->addShow($show);
            $em = $this->getDoctrine()->getManager();
            $em->persist($this->getUser());
            $em->persist($show);
            $em->flush();
            $this->addFlash('success', 'Série ajoutée aux favorites');
        }
        return $this->redirectToRoute('tv_show_display', array('id' => $id));
    }

    /**
     * @Route("/removeFromFav/{id}", name="tv_show_remove_from_fav")
     * @param $id
     * @return RedirectResponse
     */
    public function removeFromFavoritesAction($id)
    {
        $show = $this->getShow($id);
        if ($this->getUser()->getShows()->contains($show)) {
            $this->getUser()->removeShow($show);
            $em = $this->getDoctrine()->getManager();
            $em->persist($this->getUser());
            $em->persist($show);
            $em->flush();
            $this->addFlash('success', 'Série enlevée des favorites');
        } else {
            $this->addFlash('warning', 'Série non favorite');
        }
        return $this->redirectToRoute('tv_show_display', array('id' => $id));
    }

    /**
     * @param $id
     * @return TVShow
     */
    private function getShow($id)
    {
        $show = $this->getDoctrine()->getRepository('AppBundle:TVShow')->find($id);
        if (!$show) {
            $show = $this->get('myshows.fetcher.shows')->getShow($id);
        }
        if (!$show) {
            throw new NotFoundHttpException('Pas de série avec cet id');
        }
        return $show;
    }

}
