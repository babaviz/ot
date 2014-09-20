<?php

namespace OT\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class CourseController extends Controller
{

    public function adminCourseListAllAction()
    {
        $em = $this->getDoctrine()->getManager();
        $courses = $em->getRepository('OTBackendBundle:Course')->findByStatus('ACTIVE');
        $pending_number = $em->getRepository('OTBackendBundle:Course')->getPendingNumber();
        return $this->render('OTBackendBundle:Course:admin_course_list_all.html.twig', array(
                'courses'=>$courses,
                'pending_number'=>$pending_number
            ));    
    }

    public function adminCourseListPendingAction()
    {
        $em = $this->getDoctrine()->getManager();
        $courses = $em->getRepository('OTBackendBundle:Course')->findByStatus('PENDING');
        $pending_number = $em->getRepository('OTBackendBundle:Course')->getPendingNumber();

        return $this->render('OTBackendBundle:Course:admin_course_list_pending.html.twig', array(
                'courses'=>$courses,
                'pending_number'=>$pending_number
            ));
    }

    public function adminCourseListRecordAction()
    {
        $em = $this->getDoctrine()->getManager();
            
        $pending_number = $em->getRepository('OTBackendBundle:Course')->getPendingNumber();
        return $this->render('OTBackendBundle:Course:admin_course_list_record.html.twig', array('courseRecords'=>array(),'pending_number'=>$pending_number));
    }

    public function adminCourseChangeStatusAction($courseid, $status, $redirect)
    {
        $em = $this->getDoctrine()->getManager();
        $course = $em->getRepository('OTBackendBundle:Course')->findOneById($courseid);
        $course->setStatus($status);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('The course %course% has been set as',array('%course%'=>$course->getName())) . $this->get('translator')->trans(strtolower($status))
        );

        return $this->redirect($this->generateUrl($redirect));
    }

}
