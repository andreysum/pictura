<?php

namespace AppBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * Class PicturaController
 * Содержит общую логику сайта Pictura
 * @package AppBundle\Controller
 */
class PicturaController extends Controller
{
    private $baseDir;
    /**
     * @var array Общие для всех контроллеров параметры для рендеринга видов
     */
    private $renderParams = array();


    public function navigationAction() {
        $this->renderParams = array(
            'base_dir' => '',
            'menu' => $this->getMenu(),
            'categories' => $this->getCategories(),
        );

        return $this->render('menu-sidebar.html.twig', $this->renderParams);
    }

    /**
     * @return array
     */
    public function getRenderParams()
    {
        return $this->renderParams;
    }

    protected function setRenderParam($name, $value) {
        $this->renderParams[$name] = $value;
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
                'url' => 'about',
            ),

            'contacts' => array(
                'title' => 'contacts',
                'url' => 'contacts',
            ),
/*
            'exhibitions' => array(
                'title' => 'exhibitions',
                'url' => 'exhibitions',
            ),
*/
            'reviews' => array(
                'title' => 'reviews',
                'url' => 'reviews',
            ),

        );
    }

    protected function getBaseDir() {
        if ($this->baseDir === null) {
            $this->baseDir = realpath($this->container->getParameter('kernel.root_dir') . '/../web') . DIRECTORY_SEPARATOR;
            $this->renderParams['base_dir'] = $this->baseDir;
            $this->setRenderParam('categories', $this->getCategories());
        }

        return $this->baseDir;
    }

    /**
     * Возвращает список изображений поддерживаемых типов в указанной директории.
     * @return array
     */
    public function getImageNames($dir)
    {
        $imageNames = array();
        if ($handle = opendir($dir)) {
            while (false !== ($entry = readdir($handle))) {

                if ($entry != "." && $entry != ".." && (preg_match("/^[^\.]+\.(?:jpg|png|gif|jpeg)$/i", $entry) == 1)) {
                    $imageNames[] = $entry;
                }
            }
            closedir($handle);
        }

        return $imageNames;
    }

    /**
     * Возвращает список под-директорий в указанной директории.
     * @return array
     */
    protected function getDirNames($dir)
    {
        $dir = rtrim($dir, '/');
        $subdirsPaths = glob($dir.'/*', GLOB_ONLYDIR);

        $subdirNames = array();
        foreach ($subdirsPaths as $subdirsPath) {
            $subdirNames[] = basename($subdirsPath);
        }
        return $subdirNames;
    }

    private function getCategories() {
        $categories = array();
        $dirNames = $this->getDirNames($this->getBaseDir().'bundles/app/images/categories');
        foreach ($dirNames as $dirName) {
            $id = str_replace(' ', '-', $dirName);
            $categories[] = array(
                'id' => $id,
                'name' => $dirName
            );
        }
        return $categories;
    }
}
