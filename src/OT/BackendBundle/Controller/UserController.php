<?php

namespace OT\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Template;
use Symfony\Component\HttpFoundation\Request;

use OT\BackendBundle\Form\ChangePasswordType;
use OT\BackendBundle\Form\ForceChangePasswordType;
use OT\BackendBundle\Form\Model\ChangePassword;
use OT\BackendBundle\Form\Model\ForceChangePassword;


class UserController extends Controller
{

    public function adminTeacherListAction()
    {
      $em = $this->getDoctrine()->getManager();
      $admins = $em->getRepository('OTBackendBundle:User')->findByRoles('ADMIN');
      $teachers = $em->getRepository('OTBackendBundle:User')->findByRoles('TEACHER');
      return $this->render('OTBackendBundle:User:admin_teacher_list.html.twig', array(
            'teachers'=>array_merge($admins,$teachers)));    
    }

    public function adminLearnerListAction()
    {
      $em = $this->getDoctrine()->getManager();
      $learners = $em->getRepository('OTBackendBundle:User')->findByRoles('LEARNER');
      return $this->render('OTBackendBundle:User:admin_learner_list.html.twig', array(
            'learners'=>$learners));    
    }

    public function adminAccountOverviewAction()
    {
        $em = $this->getDoctrine()->getManager();
        $teacher_sum = $em->getRepository('OTBackendBundle:User')->getTeacherBalanceSum()[1];
        $learner_sum = $em->getRepository('OTBackendBundle:User')->getLearnerBalanceSum()[1];
        $teacher_number = $em->getRepository('OTBackendBundle:User')->getTeacherNumber()[1];
        $learner_number = $em->getRepository('OTBackendBundle:User')->getLearnerNumber()[1];
        $admin_number = $em->getRepository('OTBackendBundle:User')->getAdminNumber()[1];


        return $this->render('OTBackendBundle:User:admin_account_overview.html.twig', array(
                'teacher_sum'=>$teacher_sum,
                'learner_sum'=>$learner_sum,
                'teacher_number'=>$teacher_number,
                'learner_number'=>$learner_number,
                'admin_number'=>$admin_number
            ));    
    }
    /**
     * @Template("::two.html.twig")
     */
    public function changeCurrentPasswordAction(Request $request, $redirect="entrance")
    {

      $changePasswordModel = new ChangePassword();
      $form = $this->createForm(new ChangePasswordType(), $changePasswordModel);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $username = $this->getUser()->getName();
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('OTBackendBundle:User')->findOneByName($username);
        
        $user->setPassword($changePasswordModel->newPassword);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('Your password has been changed successfully.')
        );

        return $this->redirect($this->generateUrl($redirect));
      }

      return $this->render('OTBackendBundle:User:changePassword.html.twig', array(
          'form' => $form->createView(),
          'redirect' => 'entrance',
          'force' => 'false',
      ));      
    }

    public function forceChangePasswordAction(Request $request, $username="")
    {
      $forceChangePasswordModel = new ForceChangepassword();
      $form = $this->createForm(new ForceChangePasswordType(), $forceChangePasswordModel);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository('OTBackendBundle:User')->findOneByName($forceChangePasswordModel->username);

        if ($user==null){
            $this->get('session')->getFlashBag()->add(
            'warning',
            $this->get('translator')->trans('Cannot find user: '.$forceChangePasswordModel->username));

            return $this->redirect($this->generateUrl('admin_force_change_password'));

        }

        $user->setPassword($forceChangePasswordModel->newPassword);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('Password has been changed successfully for user: '.$forceChangePasswordModel->username)
        );

        return $this->redirect($this->generateUrl('admin_dashboard'));

      }

      return $this->render('OTBackendBundle:User:changePassword.html.twig', array(
          'form' => $form->createView(),
          'username' => $username,
          'force' => 'true',
      ));      

    }

}
