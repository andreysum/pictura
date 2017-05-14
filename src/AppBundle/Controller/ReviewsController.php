<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class ReviewsController extends PicturaController
{

    /**
     * @Route("/reviews/")
     */
    public function reviewsAction(Request $request)
    {
        return $this->render('reviews/reviews.html.twig', $this->renderParams);
    }
}
