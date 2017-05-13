<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class DefaultController extends PicturaController
{
    /**
     * @Route("/", name="homepage")
     */
    public function indexAction(Request $request)
    {
        $posts = $this->getIndexPosts();

        $this->renderParams['posts'] = $posts;
        $this->renderParams['base_dir'] = $this->getBaseDir();

        return $this->render('default/index.html.twig', $this->renderParams);
    }

    private function getPostContents() {
        return json_decode(file_get_contents($this->getBaseDir().'bundles/app/content.json'), true);
    }

    /**
     * Выбирает из папки web/bundles/app/images/index файлы изображений поддерживаемых форматов (jpg, png, gif, jpeg) и формирует массив из их имен
     * @return array
     */
    private function getPostImageNames() {
        $imageNames = array();
        if ($handle = opendir($this->getBaseDir().'bundles/app/images/index')) {
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
     * Формирует блок постов, состоящий либо из изображений, либо из текстовых блоков.
     * @return array - набор постов, содержащих тип и содержимое.
     */
    private function getIndexPosts()
    {
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
        return $posts;
    }
}
