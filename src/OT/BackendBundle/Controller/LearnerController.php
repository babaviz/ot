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
        
    }


}
