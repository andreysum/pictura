<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class ReviewsController extends PicturaController
{

    /**
     * @Route("/reviews", name="reviews")
     */
    public function reviewsAction(Request $request)
    {

        return $this->render('reviews/reviews.html.twig', array( "reviews" => $this->getRevews()));
    }

    private function getRevews()
    {
        $content = json_decode(file_get_contents($this->getBaseDir().'bundles/app/content.json'), true);

        return isset($content['reviews']) ? $content['reviews'] : array();

    }
}
