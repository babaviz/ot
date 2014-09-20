<?php

namespace OT\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use OT\BackendBundle\Entity\Course;
use OT\BackendBundle\Entity\User;

use OT\BackendBundle\Form\CourseType;

/**
 * Course controller.
 *
 */
class CourseController extends Controller
{

    /**
     * Lists all Course entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('OTBackendBundle:Course')->findAll();

        return $this->render('OTBackendBundle:Course:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Course entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Course();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('admin_course_show', array('id' => $entity->getId())));
        }

        return $this->render('OTBackendBundle:Course:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Course entity.
     *
     * @param Course $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Course $entity)
    {
        $form = $this->createForm(new CourseType(), $entity, array(
            'action' => $this->generateUrl('admin_course_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Course entity.
     *
     */
    public function newAction()
    {
        $entity = new Course();
        $form   = $this->createCreateForm($entity);

        return $this->render('OTBackendBundle:Course:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Course entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OTBackendBundle:Course')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('OTBackendBundle:Course:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Course entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OTBackendBundle:Course')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('OTBackendBundle:Course:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Course entity.
    *
    * @param Course $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Course $entity)
    {
        $form = $this->createForm(new CourseType(), $entity, array(
            'action' => $this->generateUrl('admin_course_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Course entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OTBackendBundle:Course')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Course entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('admin_course_edit', array('id' => $id)));
        }

        return $this->render('OTBackendBundle:Course:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Course entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OTBackendBundle:Course')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Course entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('admin_course'));
    }

    /**
     * Creates a form to delete a Course entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('admin_course_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }

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

    private function createAdminAssignTeacherForm($courseid)
    {
        return $this->createFormBuilder()
                    ->setAction($this->generateUrl('admin_course_assign_teacher',['courseid'=>$courseid]))
                    ->add('courseid','hidden',['data'=>$courseid])
                    ->add('submit', 'submit', array('label' => 'Add'))
                    ->getForm();
    }

    public function adminAssignTeacherAction(Request $request, $courseid)
    {
        $em = $this->getDoctrine()->getManager();
        $pending_number = $em->getRepository('OTBackendBundle:Course')->getPendingNumber();

        $course=$em->getRepository('OTBackendBundle:Course')->findOneById($courseid);
        //$teachers=$em->getRepository('OTBackendBundle:Course')->findByTeachers(new User());

        $form=$this->createAdminAssignTeacherForm($courseid);

        $form->handleRequest($request);

        if ($form->isValid()) {

        }


        return $this->render('OTBackendBundle:Course:admin_course_assign_teacher.html.twig',
            [
                'course'=>$course,
                //'teachers'=>$teachers,
                'form'=>$form->createView(),
                'pending_number'=>$pending_number,
            ]);
    }
}
