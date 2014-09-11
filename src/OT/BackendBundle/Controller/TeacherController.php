<?php

namespace OT\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class TeacherController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('OTBackendBundle:Teacher:dashboard.html.twig', array(
            ));    
    }

}
