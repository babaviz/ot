<?php

namespace OT\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * Homepage controller.
 *
 */
class HomepageController extends Controller
{

    /**
     * Lists all Course entities.
     *
     */
    public function indexAction()
    {

        return $this->render('OTBackendBundle:Homepage:index.html.twig');
    }
    
}
