<?php

namespace OT\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;


class LearnerController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('OTBackendBundle:Learner:dashboard.html.twig', array(
            ));    
    }

    private function createChooseTeacherForm($course_id)
    {

    	$em = $this->getDoctrine()->getManager();
      	$query = $em->getRepository('OTBackendBundle:User')->findBy(['role'=>'ROLE_TEACHER']);

      	$entities=$query;
        $choices[-1]='';

        foreach ($entities as $entity){
        	$choices[$entity->getId()]=$entity->getName();
        }

    	return $this->get('form.factory')->createNamedBuilder('form2')
    				->setAction($this->generateUrl('learner_booking_choose_teacher'))
                    ->add('Course','hidden',['data'=>$course_id])
		            ->add('Teacher','choice',['label'=>' ','choices'=>$choices,'attr'=>['onchange'=>'document.forms.form2.submit()']])
    				->getForm();
    }

    private function createChooseCourseForm()
    {

    	$em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('OTBackendBundle:Course')->findBy(['status'=>'ACTIVE']);

        $choices[-1]='';

        foreach ($entities as $entity){
        	$choices[$entity->getId()]=$entity->getName();
        }

    	return $this->get('form.factory')->createNamedBuilder('form1')
    				->setAction($this->generateUrl('learner_booking_choose_course'))
    				->setMethod('POST')
		            ->add('Course','choice',['label'=>' ','choices'=>$choices,'attr'=>['onchange'=>'document.forms.form1.submit()']])
    				->getForm();
    }


    public function bookingChooseTeacherAction(Request $request)
    {
        $teacher_form=$this->createChooseTeacherForm(1);//1 is unused course_id
        $teacher_form->handleRequest($request);

        //$teacher_selected=$this->createChooseTeacherForm($request->get('Course'));
        //$teacher_selected->get('Teacher')->setData($request->get('Teacher'));
    
        $ot_calendar=$this->get('ot_calendar');
        $usertz=$this->get('security.context')->getToken()->getUser()->getTimeZone();
        date_default_timezone_set($usertz);

        $cd=new \DateTime('now');
        for ($i=0;$i<7;$i++){
            $day[$i]=$cd->format("m-d");
            date_add($cd, date_interval_create_from_date_string('1 day'));
        }

        $em = $this->getDoctrine()->getManager();
        $entity=$em->getRepository('OTBackendBundle:Weekplan')->findOneByTeacher(2);

        $start_date_object=new \DateTime('now',new \DateTimezone('GMT'));
        $start_date=$start_date_object->format('Y-m-d 00:00:00');

        $or_all=str_repeat('F', 1008);

        if ($start_date!==null){
                //start override schedule by learner's schedule
                //$em = $this->getDoctrine->getManager();

                $start_date_gmt = $start_date;
                $end_date_gmt = date_add(new \DateTime($start_date_gmt,new \DateTimezone('GMT')), date_interval_create_from_date_string('7 days'))->format('Y-m-d H:i:s');

                $query = $em->createQueryBuilder()
                            ->select('b')
                            ->from('OTBackendBundle:BookedTime','b')
                            ->where('b.teacher=:teacher')
                            ->andWhere('b.start_time >=:start_time')
                            ->andWhere('b.end_time < :end_time')
                            ->andWhere('b.status=:status')
                            ->setParameters(['start_time'=>$start_date_gmt,
                                            'end_time'=>$end_date_gmt,
                                            'teacher'=>$em->getRepository('OTBackendBundle:User')->findOneById(2),
                                            'status'=>'BOOKED'
                                ])
                      ->getQuery()->getResult();

                $dp='<pre>';
                foreach ($query as $r){
                    $dp.=print_r($r->getStartTime());
                    $dp.=print_r($r->getEndTime());
                    $dp.=',';
                }
                
                $dp.='</pre>';

                foreach ($query as $r){
                    $m10=$ot_calendar->time_diff_m10($r->getStartTime(),$r->getEndTime());
                    $dp.=$m10.'(m10)';
                    $pos_start=$ot_calendar->time_diff_m10(new \Datetime($start_date),$r->getStartTime());
                    $or_all=$ot_calendar->override_1008($or_all,$ot_calendar->create_override($pos_start,$m10));
                    $dp.=$pos_start.'(pos_start)<br/>';
                    $dp.=$or_all;
                }

                //return new Response($dp.'<hr/>start '.$start_date_gmt.'<hr/>end '.$end_date_gmt);
            }

        $entity=$ot_calendar->parse_weekplan($entity,$usertz);
        $entity=$ot_calendar->render_parsed_weekplan_learner($entity,date_create('now',new \DateTimezone('GMT'))->format('Y-m-d H:i:s'));
        $entity=$ot_calendar->override_1008($entity,$or_all);

        return $this->render('OTBackendBundle:Learner:booking_choose_time.html.twig', 
            [
            'form_teacher'=>$teacher_form->createView(),
            'entity'=>$entity,
            'day'=>$day
            ]
        );
    }

    public function bookingChooseCourseAction(Request $request)
    {

        $course_form=$this->createChooseCourseForm();
        $course_form->handleRequest($request);

        if ($course_form->isValid())
        {
            $course_selected=$this->createChooseCourseForm();
            $course_selected->get('Course')->setData($course_form->get('Course')->getData());

            return $this->render('OTBackendBundle:Learner:booking_choose_teacher.html.twig', 
            [
            'form_course'=>$course_selected->createView(),
            'form_teacher'=>$this->createChooseTeacherForm($course_form->get('Course')->getData())->createView()
            ]
            );
        }

        return $this->render('OTBackendBundle:Learner:booking_choose_course.html.twig', 
        	[
        	'form_course'=>$this->createChooseCourseForm()->createView()
        	]
        	);
    }

}
