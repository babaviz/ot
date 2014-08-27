<?php

namespace OT\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class DefaultController extends Controller
{
    public function indexAction($name)
    {
        return $this->render('OTBackendBundle:Default:index.html.twig', array('name' => $name));
    }
}
