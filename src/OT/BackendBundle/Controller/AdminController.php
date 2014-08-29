<?php

namespace OT\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('OTBackendBundle:Admin:dashboard.html.twig', array(
            ));    
    }

    public function settingAction()
    {
        return $this->render('OTBackendBundle:Admin:setting.html.twig', array(
            ));    
    }

}
