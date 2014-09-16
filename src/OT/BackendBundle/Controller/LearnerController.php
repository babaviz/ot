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
        $entities = $em->getRepository('OTBackendBundle:User')->findBy(['role'=>'TEACHER','Courses'=>$course_id]);

        foreach ($entities as $entity){
        	$choices[$entity->getId()]=$entity->getName();
        }

    	return $this->createFormBuilder()
    				->setAction($this->generateUrl('learner_booking_choose_course'))
    				->setMethod('PUT')
		            ->add('Teacher','choice',['choices'=>$choices])
		            ->add('Choose', 'submit', ['label' => 'Choose'])
    				->getForm();
    }

    private function createChooseCourseForm()
    {

    	$em = $this->getDoctrine()->getManager();
        $entities = $em->getRepository('OTBackendBundle:Course')->findBy(['status'=>'ACTIVE']);

        foreach ($entities as $entity){
        	$choices[$entity->getId()]=$entity->getName();
        }

    	return $this->createFormBuilder()
    				->setAction($this->generateUrl('learner_booking_choose_teacher'))
    				->setMethod('POST')
		            ->add('Course','choice',['choices'=>$choices])
		            ->add('Choose', 'submit', ['label' => 'Choose'])
    				->getForm();
    }


    public function bookingChooseTeacherAction(Request $request)
    {
    	$course_form=$this->createChooseCourseForm();
    	$course_form->handleRequest($request);

    	if ($course_form->isValid())
    	{
    		return $this->render('OTBackendBundle:Learner:booking_choose_teacher.html.twig', 
        	[
        	'form_teacher'=>$this->createChooseTeacherForm($course_form->get('Course'))->createView()
        	]
        	);
    	}
    }

    public function bookingChooseCourseAction()
    {

        return $this->render('OTBackendBundle:Learner:booking_choose_course.html.twig', 
        	[
        	'form_course'=>$this->createChooseCourseForm()->createView()
        	]
        	);
    }

}
