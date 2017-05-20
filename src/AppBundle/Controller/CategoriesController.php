<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

/**
 * Class CategoriesController
 * @package AppBundle\Controller
 */
class CategoriesController extends PicturaController
{
    /**
     * @Route("/categories/{category}", name="categories")
     */
    public function categoriesAction($category)
    {
        return $this->render('categories/categories.html.twig', array('category' => $category, 'photos' => $this->getCategoryPhotos($category)));
    }

    private function getCategoryPhotos($category) {
        $content = json_decode(file_get_contents($this->getBaseDir().'bundles/app/content.json'), true);

        return isset($content['categories'][$category]) ? $content['categories'][$category] : array();
    }

}
