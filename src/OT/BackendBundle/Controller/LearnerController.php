<?php

namespace OT\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;

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
      	$query = $em->createQuery("SELECT u FROM OTBackendBundle:User u
                                    INNER JOIN u.Courses c
      								WHERE c.id=:course_id
      								")
      				->setParameter('course_id',$course_id)
      				->getResult();

      	$entities=$query;

        //getRepository('OTBackendBundle:User')->findBy(['role'=>'TEACHER','Courses'=>$course_id]);

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
        $teacher_form=$this->createChooseTeacherForm(1);
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

        return $this->render('OTBackendBundle:Learner:booking_choose_time.html.twig', 
            [
            'form_teacher'=>$teacher_form->createView(),
            'entity'=>$ot_calendar->render_parsed_weekplan_learner(
                        $ot_calendar->parse_weekplan($entity,$usertz),
                        date("Y-m-d H:i:s ").$usertz),
            'day'=>$day,
            //'message'=>$teacher_selected->get('Course')
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
