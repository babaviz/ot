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
        $userid= $this->get('security.context')->getToken()->getUser()->getId();

        $entities = $em->getRepository('OTBackendBundle:BookedTime')->findById(3);

        return $this->render('OTBackendBundle:Teacher:bookedtime_list.html.twig',['entities'=>$entities]);
    }

}
