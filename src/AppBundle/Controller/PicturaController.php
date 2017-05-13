<?php

namespace AppBundle\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Class PicturaController
 * Содержит общую логику для всех контроллеров сайта Pictura
 * @package AppBundle\Controller
 */
class PicturaController extends Controller
{
    /**
     * @var array Общие для всех контроллеров параметры для рендеринга видов
     */
    protected $renderParams;

    private $baseDir = null;

    function __construct()
    {
        $this->renderParams = array(
            'base_dir' => '',
            'menu' => $this->getMenu(),
        );
    }

    /**
     * Возвращает пункты главного меню сайта
     * @return array
     */
    private function getMenu()
    {
        return array(
            'about' => array(
                'title' => 'about',
                'url' => '/about/',
            ),

            'contacts' => array(
                'title' => 'contacts',
                'url' => '/contacts/',
            ),

            'exhibitions' => array(
                'title' => 'exhibitions',
                'url' => '/exhibitions/',
            ),

            'reviews' => array(
                'title' => 'reviews',
                'url' => '/reviews/',
            ),

        );
    }

    protected function getBaseDir() {
        if ($this->baseDir === null) {
            $this->baseDir = realpath($this->container->getParameter('kernel.root_dir') . '/../web') . DIRECTORY_SEPARATOR;
            $this->renderParams['base_dir'] = $this->baseDir;
        }

        return $this->baseDir;
    }
}
