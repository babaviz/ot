<?php

namespace OT\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;


/**
 * BookedTime controller.
 *
 */
class BookedTimeController extends Controller
{
    public function upcominglistAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ot_calendar=$this->get('ot_calendar');
        $userid=$this->get('security.context')->getToken()->getUser()->getId();

        $entities = $em->getRepository('OTBackendBundle:BookedTime')->findBy(['teacher'=>$userid,'status'=>'BOOKED']);

        return $this->render('OTBackendBundle:Teacher:bookedtime_upcoming_list.html.twig',['entities'=>$entities]);
    }

    public function pastlistAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ot_calendar=$this->get('ot_calendar');
        $userid=$this->get('security.context')->getToken()->getUser()->getId();

        $entities = $em->getRepository('OTBackendBundle:BookedTime')->findBy(['teacher'=>$userid,'status'=>'PAST']);

        return $this->render('OTBackendBundle:Teacher:bookedtime_past_list.html.twig',['entities'=>$entities]);
    }

    public function learnerChooseTimeAction()
    {
        
    }

}
