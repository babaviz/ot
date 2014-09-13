<?php

namespace OT\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use OT\BackendBundle\Entity\BookedTime;
use OT\BackendBundle\Form\BookedTimeType;

/**
 * BookedTime controller.
 *
 */
class BookedTimeController extends Controller
{
    public function listAction()
    {
        $em = $this->getDoctrine()->getManager();
        $ot_calendar=$this->get('ot_calendar');
        $userid=$this->get('security.context')->getToken()->getUser()->getId();

        $entities = $em->getRepository('OTBackendBundle:BookedTime')->findByTeacher($userid);

        return $this->render('OTBackendBundle:Teacher:bookedtime_list.html.twig',['entities'=>$entities,'message'=>$ot_calendar->timezoned_utc_string('2014-09-14 04:14','Asia/Hong_Kong','m-d H:i')]);
    }

}
