<?php

namespace OT\BackendBundle\Controller;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use OT\BackendBundle\Entity\BookedTime;
use OT\BackendBundle\Form\BookedTimeType;

/**
 * BookedTime controller.
 *
 */
class BookedTimeController extends Controller
{

    /**
     * Lists all BookedTime entities.
     *
     */
    public function indexAction()
    {
        $em = $this->getDoctrine()->getManager();

        $entities = $em->getRepository('OTBackendBundle:BookedTime')->findAll();

        return $this->render('OTBackendBundle:BookedTime:index.html.twig', array(
            'entities' => $entities,
        ));
    }
    /**
     * Creates a new BookedTime entity.
     *
     */
    public function createAction(Request $request)
    {
        $entity = new BookedTime();
        $form = $this->createCreateForm($entity);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $em->persist($entity);
            $em->flush();

            return $this->redirect($this->generateUrl('teacher_bookedtime_show', array('id' => $entity->getId())));
        }

        return $this->render('OTBackendBundle:BookedTime:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Creates a form to create a BookedTime entity.
     *
     * @param BookedTime $entity The entity
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createCreateForm(BookedTime $entity)
    {
        $form = $this->createForm(new BookedTimeType(), $entity, array(
            'action' => $this->generateUrl('teacher_bookedtime_create'),
            'method' => 'POST',
        ));

        $form->add('submit', 'submit', array('label' => 'Create'));

        return $form;
    }

    /**
     * Displays a form to create a new BookedTime entity.
     *
     */
    public function newAction()
    {
        $entity = new BookedTime();
        $form   = $this->createCreateForm($entity);

        return $this->render('OTBackendBundle:BookedTime:new.html.twig', array(
            'entity' => $entity,
            'form'   => $form->createView(),
        ));
    }

    /**
     * Finds and displays a BookedTime entity.
     *
     */
    public function showAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OTBackendBundle:BookedTime')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BookedTime entity.');
        }

        $deleteForm = $this->createDeleteForm($id);

        return $this->render('OTBackendBundle:BookedTime:show.html.twig', array(
            'entity'      => $entity,
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
     * Displays a form to edit an existing BookedTime entity.
     *
     */
    public function editAction($id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OTBackendBundle:BookedTime')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BookedTime entity.');
        }

        $editForm = $this->createEditForm($entity);
        $deleteForm = $this->createDeleteForm($id);

        return $this->render('OTBackendBundle:BookedTime:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }

    /**
    * Creates a form to edit a BookedTime entity.
    *
    * @param BookedTime $entity The entity
    *
    * @return \Symfony\Component\Form\Form The form
    */
    private function createEditForm(BookedTime $entity)
    {
        $form = $this->createForm(new BookedTimeType(), $entity, array(
            'action' => $this->generateUrl('teacher_bookedtime_update', array('id' => $entity->getId())),
            'method' => 'PUT',
        ));

        $form->add('submit', 'submit', array('label' => 'Update'));

        return $form;
    }
    /**
     * Edits an existing BookedTime entity.
     *
     */
    public function updateAction(Request $request, $id)
    {
        $em = $this->getDoctrine()->getManager();

        $entity = $em->getRepository('OTBackendBundle:BookedTime')->find($id);

        if (!$entity) {
            throw $this->createNotFoundException('Unable to find BookedTime entity.');
        }

        $deleteForm = $this->createDeleteForm($id);
        $editForm = $this->createEditForm($entity);
        $editForm->handleRequest($request);

        if ($editForm->isValid()) {
            $em->flush();

            return $this->redirect($this->generateUrl('teacher_bookedtime_edit', array('id' => $id)));
        }

        return $this->render('OTBackendBundle:BookedTime:edit.html.twig', array(
            'entity'      => $entity,
            'edit_form'   => $editForm->createView(),
            'delete_form' => $deleteForm->createView(),
        ));
    }
    /**
     * Deletes a BookedTime entity.
     *
     */
    public function deleteAction(Request $request, $id)
    {
        $form = $this->createDeleteForm($id);
        $form->handleRequest($request);

        if ($form->isValid()) {
            $em = $this->getDoctrine()->getManager();
            $entity = $em->getRepository('OTBackendBundle:BookedTime')->find($id);

            if (!$entity) {
                throw $this->createNotFoundException('Unable to find BookedTime entity.');
            }

            $em->remove($entity);
            $em->flush();
        }

        return $this->redirect($this->generateUrl('teacher_bookedtime'));
    }

    /**
     * Creates a form to delete a BookedTime entity by id.
     *
     * @param mixed $id The entity id
     *
     * @return \Symfony\Component\Form\Form The form
     */
    private function createDeleteForm($id)
    {
        return $this->createFormBuilder()
            ->setAction($this->generateUrl('teacher_bookedtime_delete', array('id' => $id)))
            ->setMethod('DELETE')
            ->add('submit', 'submit', array('label' => 'Delete'))
            ->getForm()
        ;
    }
}
