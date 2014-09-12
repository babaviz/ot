<?php

namespace OT\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use OT\BackendBundle\Entity\Weekplan;
use OT\BackendBundle\Form\WeekplanType;

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
    public function listAction()
    {
        
        $em = $this->getDoctrine()->getManager();
        $ot_calendar=$this->get('ot_calendar');

        $userid= $this->get('security.context')->getToken()->getUser()->getId();
        $entity = $em->getRepository('OTBackendBundle:Weekplan')->findOneByTeacher($userid);

        return $this->render('OTBackendBundle:Teacher:weekplan_list.html.twig', array(
            'entity' => $ot_calendar->render_parsed_weekplan_agenda($ot_calendar->parse_weekplan($entity,'America/Denver'))
        ));
        
        /*
        $ot_calendar=$this->get('ot_calendar');

        $plan=new Weekplan();

        return new Response(
            var_dump($ot_calendar->push_calendar_timezone($plan))
        );*/
    }
}
