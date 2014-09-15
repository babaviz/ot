<?php

namespace OT\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\FormBuilderInterface;

use OT\BackendBundle\Entity\Weekplan;
use OT\BackendBundle\Form\WeekplanType;

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

        $em = $this->getDoctrine()->getManager();
        $ot_calendar=$this->get('ot_calendar');

        $userid= $this->get('security.context')->getToken()->getUser()->getId();
        $entity = $em->getRepository('OTBackendBundle:Weekplan')->findOneByTeacher($userid);


        $add_form=$this->createFormBuilder(null,['action' => $this->generateUrl('teacher_weekplan_list')])
                                    ->add('Weekday', 'choice',['choices'=>
                                            ['1'=>'Monday',
                                            '2'=>'Tuesday',
                                            '3'=>'Wednesday',
                                            '4'=>'Thursday',
                                            '5'=>'Friday',
                                            '6'=>'Saturday',
                                            '7'=>'Sunday']
                                        ])
                                    ->add('From','choice',['choices'=>$ot_calendar->generateFromDayTimeList()])
                                    ->add('To','choice',['choices'=>$ot_calendar->generateToDayTimeList()])
                                    ->add('Add', 'submit', ['label' => 'Add'])
                                    ->getForm();


        $add_form->handleRequest($request);

        if ($add_form->isValid()) {


            $i=($add_form->getData()['Weekday']-1)*144+$add_form->getData()['From'];
            $j=($add_form->getData()['Weekday']-1)*144+$add_form->getData()['To'];

            //throw $this->createAccessDeniedException($i);


            $plan=$ot_calendar->parse_weekplan($entity,'Asia/Hong_Kong');

            for ($k=$i;$k<=$j;$k++)
                $plan[$k]='F';

            $this->editWeekplanAction($plan);

            return $this->redirect($this->generateUrl('teacher_weekplan_list'));
        }


        return $this->render('OTBackendBundle:Teacher:weekplan_list.html.twig', array(
            'entity' => $ot_calendar->render_parsed_weekplan_agenda($ot_calendar->parse_weekplan($entity,'Asia/Hong_Kong')),
            'add_form' => $add_form->createView()
        ));
    }

    public function editAction(Request $request)
    {
        $choices=[];
        for ($m10=0;$m10<144;$m10++)
            $choices[$m10]=$m10;

        $add_form=$this->createFormBuilder()
            ->add($m10, 'choice', ['choices'=>$choices,'multiple'=>true,'expanded'=>true])
            ->getForm();

        return $this->render('OTBackendBundle:Teacher:weekplan_edit.html.twig',['form'=>$add_form->createView()]);
    }

    public function cleardayAction($weekday)
    {


        $em = $this->getDoctrine()->getManager();
        $ot_calendar=$this->get('ot_calendar');

        $start_m10=($weekday-1)*144;
        $end_m10=$start_m10+143;

        $userid= $this->get('security.context')->getToken()->getUser()->getId();
        $entity = $em->getRepository('OTBackendBundle:Weekplan')->findOneByTeacher($userid);

        $plan=$ot_calendar->parse_weekplan($entity,'Asia/Hong_Kong');

        for ($i=$start_m10;$i<=$end_m10;$i++)
            $plan[$i]='B';

        $this->editWeekplanAction($plan);

        return $this->redirect($this->generateUrl('teacher_weekplan_list'));

    }

    public function editWeekplanAction($plan)
    {
        $em = $this->getDoctrine()->getManager();
        $ot_calendar=$this->get('ot_calendar');

        $userid= $this->get('security.context')->getToken()->getUser()->getId();
        $entity = $em->getRepository('OTBackendBundle:Weekplan')->findOneByTeacher($userid);

        //$weekplan[($m10-$ot_calendar->get_timezone_offset('Asia/Hong_Kong')/60/10+1008)%1008]='F';
        $plan=$ot_calendar->encode_weekplan($plan,'Asia/Hong_Kong');

        $entity->setPlan($plan);
        $em->flush();

        return $this->redirect($this->generateUrl('teacher_weekplan_list'));

    }

}
