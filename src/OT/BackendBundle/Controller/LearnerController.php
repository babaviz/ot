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
        $teacher_form=$this->createChooseTeacherForm($request->request->get('Course'));
        $teacher_form->handleRequest($request);

        $course_selected=$this->createChooseCourseForm();
        $course_selected->get('Course')->setData($teacher_form->get('Course')->getData());

        $teacher_selected=$this->createChooseTeacherForm($teacher_form->get('Course')->getData());
        $teacher_selected->handleRequest($request);

        $ot_calendar=$this->get('ot_calendar');
        $usertz=$this->get('security.context')->getToken()->getUser()->getTimeZone();

        $em = $this->getDoctrine()->getManager();
        $entity=$em->getRepository('OTBackendBundle:Weekplan')->findOneByTeacher(2);

        return $this->render('OTBackendBundle:Learner:booking_choose_time.html.twig', 
            [
            'form_course'=>$course_selected->createView(),
            'form_teacher'=>$teacher_selected->createView(),
            'entity'=>$ot_calendar->render_parsed_weekplan_agenda($ot_calendar->parse_weekplan($entity,$usertz))
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
