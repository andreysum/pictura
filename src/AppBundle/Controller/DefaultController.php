<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class DefaultController extends Controller
{

    private $baseDir = '';
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

        $postContents = $this->getPostContents();
        $postTexts = $postContents['index']['posts'];
        $imageNames = $this->getPostImageNames();
        $posts = array();

        for ($i = 0; $i < 13; $i++) {
            $postItem = array();
            if (isset($imageNames[$i])) {
                $imageName = $imageNames[$i];
                $postItem['type'] = (strpos($imageName, 'c_') === 0) ? 'c_img' : 'img';
                $postItem['content'] = $imageName;
            } else {
                $postText = array_shift($postTexts);
                $postItem['type'] = 'text';
                $postItem['content'] = ($postText === null) ? '' : $postText;
            }
            $posts[$i] = $postItem;
        }
        shuffle($posts);
        for ($i = 0; $i < 13; $i++) {
            $postItem = $posts[$i];
            if ($postItem['type'] == 'c_img') {
                $replacedItem = $posts[5];
                $posts[5] = $postItem;
                $posts[$i] = $replacedItem;
            }
        }
        // replace this example code with whatever you need
        $this->baseDir = realpath($this->container->getParameter('kernel.root_dir') . '/..') . DIRECTORY_SEPARATOR;
        return $this->render('default/index.html.twig', array(
            'base_dir' => $this->baseDir,
            'menu' => $menu,
            'posts' => $posts
        ));
    }

    private function getPostContents() {
        return json_decode(file_get_contents($this->baseDir.'bundles/app/content.json'), true);
    }

    private function getPostImageNames() {
        $imageNames = array();
        if ($handle = opendir($this->baseDir.'bundles/app/images/index')) {
            while (false !== ($entry = readdir($handle))) {

                if ($entry != "." && $entry != ".." && (preg_match("/^[^\.]+\.(?:jpg|png|gif|jpeg)$/i", $entry) == 1)) {
                    $imageNames[] = $entry;
                }
            }
            closedir($handle);
        }

        return $imageNames;
    }
}
