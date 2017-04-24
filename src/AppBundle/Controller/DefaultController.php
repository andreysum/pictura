<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class DefaultController extends Controller
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $menu = array(
            'about' => array(
                'title' => 'about',
                'url' => 'about/',
            ),

            'contacts' => array(
                'title' => 'contacts',
                'url' => 'contacts/',
            ),

            'exhibitions' => array(
                'title' => 'exhibitions',
                'url' => 'exhibitions/',
            ),

            'reviews' => array(
                'title' => 'reviews',
                'url' => 'reviews/',
            ),

        );

        // replace this example code with whatever you need
        return $this->render('default/index.html.twig', array(
            'base_dir' => realpath($this->container->getParameter('kernel.root_dir').'/..').DIRECTORY_SEPARATOR,
            'menu' => $menu,
        ));
    }
}
