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
    /**
     * @Route("/changePassword")
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
