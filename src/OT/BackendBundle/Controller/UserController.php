<?php

namespace OT\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use OT\BackendBundle\Entity\User;
use OT\BackendBundle\Form\UserType;

use OT\BackendBundle\Form\Model\ChangePassword;
use OT\BackendBundle\Form\ChangePasswordType;

use OT\BackendBundle\Form\Model\ForceChangePassword;
use OT\BackendBundle\Form\ForceChangePasswordType;

use OT\BackendBundle\Entity\Weekplan;

/**
 * User controller.
 *
 */
class UserController extends Controller
{

    /**
     * Creates a new User entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new User();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            // create a Weekplan entry for the teacher
            if ($entity->getRole()=='ROLE_TEACHER'){
              $wp=new Weekplan();
              $wp->setTeacher($entity);
              $wp->setPlan('B*1008');
              $em->persist($wp);
              $em->flush();
            }

            return $this->redirect($this->generateUrl('admin_user_list'));
        }

        return $this->render('OTBackendBundle:User:admin_user_new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a User entity.
     *
     * @param User $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('admin_user_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new User entity.
     *
     */
    public function newAction()
    {
        $entity = new User();
        $entity->setAccountBalance(0);
        $entity->setCreateTime(new \Datetime (date('Y-m-d',time())));
        $form   = $this->createCreateForm($entity);

        return $this->render('OTBackendBundle:User:admin_user_new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a User entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OTBackendBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('OTBackendBundle:User:admin_user_show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing User entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OTBackendBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('OTBackendBundle:User:admin_user_edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a User entity.
    *
    * @param User $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(User $entity)
    {
        $form = $this->createForm(new UserType(), $entity, array(
            'action' => $this->generateUrl('admin_user_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing User entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OTBackendBundle:User')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find User entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('User information successfully edited.'));

            return $this->redirect($this->generateUrl('admin_user_list', array('id' => $id)));
        }

        return $this->render('OTBackendBundle:User:admin_user_edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a User entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OTBackendBundle:User')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find User entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_user_list'));
    }

    /**
     * Creates a form to delete a User entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_user_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

    public function adminUserListAction()
    {
      $em = $this->getDoctrine()->getManager();
      $users = $em->getRepository('OTBackendBundle:User')->findAll();
      return $this->render('OTBackendBundle:User:admin_user_list.html.twig', array(
            'users'=>$users));    
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


    public function profileChangePasswordAction(Request $request, $redirect="entrance")
    {

      $changePasswordModel = new ChangePassword();
      $form = $this->createForm(new ChangePasswordType(), $changePasswordModel);

      $form->handleRequest($request);

      if ($form->isSubmitted() && $form->isValid()) {
        $username = $this->getUser()->getName();
        $em = $this->getDoctrine()->getManager();
        
        //$user = $em->getRepository('OTBackendBundle:User')->findOneByName($username);
        $user= $this->get('security.context')->getToken()->getUser();
        
        $user->setPassword($changePasswordModel->newPassword);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('Your password has been changed successfully.')
        );

        return $this->redirect($this->generateUrl($redirect));
      }

      return $this->render('OTBackendBundle:User:change_password.html.twig', array(
          'form' => $form->createView(),
          'redirect' => 'entrance',
          'force' => 'false',
      ));      
    }

    public function adminChangePasswordAction(Request $request, $username="")
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

            return $this->redirect($this->generateUrl('admin_user_change_password'));

        }

        $user->setPassword($forceChangePasswordModel->newPassword);
        $em->flush();

        $this->get('session')->getFlashBag()->add(
            'success',
            $this->get('translator')->trans('Password has been changed successfully for user: '.$forceChangePasswordModel->username)
        );

        return $this->redirect($this->generateUrl('admin_dashboard'));

      }

      return $this->render('OTBackendBundle:User:change_password.html.twig', array(
          'form' => $form->createView(),
          'username' => $username,
          'force' => 'true',
      ));      

    }
    
}
