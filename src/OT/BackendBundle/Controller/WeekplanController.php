<?php

namespace OT\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use OT\BackendBundle\Entity\Weekplan;
use OT\BackendBundle\Form\WeekplanType;

/**
 * Weekplan controller.
 *
 */
class WeekplanController extends Controller
{

    /**
     * Lists all Weekplan entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $userid= $this->get('security.context')->getToken()->getUser()->getId();
        $entities = $em->getRepository('OTBackendBundle:Weekplan')->findByTeacher($userid);

        return $this->render('OTBackendBundle:Teacher:weekplan_index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new Weekplan entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new Weekplan();

        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('teacher_weekplan_show', array('id' => $entity->getId())));
        }

        return $this->render('OTBackendBundle:Teacher:weekplan_new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a Weekplan entity.
     *
     * @param Weekplan $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(Weekplan $entity)
    {
        $form = $this->createForm(new WeekplanType(), $entity, array(
            'action' => $this->generateUrl('teacher_weekplan_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new Weekplan entity.
     *
     */
    public function newAction()
    {
        $entity = new Weekplan();

        $user= $this->get('security.context')->getToken()->getUser();
        $entity->setTeacher($user);

        $form   = $this->createCreateForm($entity);

        return $this->render('OTBackendBundle:Teacher:weekplan_new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a Weekplan entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OTBackendBundle:Weekplan')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Weekplan entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('OTBackendBundle:Teacher:weekplan_show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing Weekplan entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OTBackendBundle:Weekplan')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Weekplan entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('OTBackendBundle:Teacher:weekplan_edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a Weekplan entity.
    *
    * @param Weekplan $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(Weekplan $entity)
    {
        $form = $this->createForm(new WeekplanType(), $entity, array(
            'action' => $this->generateUrl('teacher_weekplan_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing Weekplan entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OTBackendBundle:Weekplan')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find Weekplan entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('teacher_weekplan_edit', array('id' => $id)));
        }

        return $this->render('OTBackendBundle:Teacher:weekplan_edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a Weekplan entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OTBackendBundle:Weekplan')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find Weekplan entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('teacher_weekplan'));
    }

    /**
     * Creates a form to delete a Weekplan entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('teacher_weekplan_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
