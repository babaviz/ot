<?php

namespace OT\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class AdminController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('OTBackendBundle:Admin:dashboard.html.twig', array(
                // ...
            ));    }

    public function teacherAction()
    {
        return $this->render('OTBackendBundle:Admin:teacher.html.twig', array(
                // ...
            ));    }

    public function learnerAction()
    {
        return $this->render('OTBackendBundle:Admin:learner.html.twig', array(
                // ...
            ));    }

    public function couseAction()
    {
        return $this->render('OTBackendBundle:Admin:couse.html.twig', array(
                // ...
            ));    }

    public function accountAction()
    {
        return $this->render('OTBackendBundle:Admin:account.html.twig', array(
                // ...
            ));    }

    public function settingAction()
    {
        return $this->render('OTBackendBundle:Admin:setting.html.twig', array(
                // ...
            ));    }

}
