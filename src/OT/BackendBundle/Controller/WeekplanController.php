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
        
    }

    public function editAction(Request $request)
    {
        $choices=[];
        for ($m10=0;$m10<144;$m10++)
            $choices[$m10]=$m10;

        $form=$this->createFormBuilder()
            ->add($m10, 'choice', ['choices'=>$choices,'multiple'=>true,'expanded'=>true])
            ->getForm();

        return $this->render('OTBackendBundle:Teacher:weekplan_edit.html.twig',['form'=>$form->createView()]);
    }
}
