<?php

namespace OT\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormBuilderInterface;

use Doctrine\ORM;

use Symfony\Component\HttpKernel\Exception\AccessDeniedHttpException;

/**
 * Weekplan controller.
 *
 */
class WeekplanController extends Controller
{
    /**
     * Lists all Weekplan entities.
     *
     */
    public function listAction(Request $request)
    {
        $calendar = $this->get('ot_calendar_v2');
        //$calendar->create_or_update_event(null,'1','2014-09-26 05:00','2014-09-26 06:00','status',1,3,2);
        $userid=$this->get('security.context')->getToken()->getUser()->getId();

        $response = $calendar->fetch_events(null,'2014-09-25 05:00','2014-09-25 06:00');

        return $this->render('OTBackendBundle:Teacher:weekplan_list.html.twig',
        	['response'=>$response]);
    }

}
