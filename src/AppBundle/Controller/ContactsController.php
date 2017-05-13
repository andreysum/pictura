<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Yaml\Yaml;

class ContactsController extends PicturaController
{

    /**
     * @Route("/contacts/")
     */
    public function contactsAction(Request $request)
    {
        return $this->render('contacts/contacts.html.twig', $this->renderParams);
    }
}
