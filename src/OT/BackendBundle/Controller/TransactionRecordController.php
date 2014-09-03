<?php

namespace OT\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

use OT\BackendBundle\Entity\TransactionRecord;
use OT\BackendBundle\Entity\User;

use Symfony\Component\HttpFoundation\Request;

use OT\BackendBundle\Form\TransferToType;
use OT\BackendBundle\Form\Model\TransferTo;

class TransactionRecordController extends Controller
{
    public function accountTranscationRecordListAction()
    {
    	$transactions = $this->getDoctrine()->getManager()->getRepository('OTBackendBundle:TransactionRecord')->findAll();
    
        return $this->render('OTBackendBundle:TransactionRecord:account_transactionrecord_list.html.twig', array('transactions'=>$transactions));
    }

    public function adminAccountTransferAction(Request $request)
    {

    	$TransferToModel = new TransferTo();
     	$form = $this->createForm(new TransferToType(), $TransferToModel);

     	$form->handleRequest($request);

	    if ($form->isSubmitted() && $form->isValid()) {

	        $em = $this->getDoctrine()->getManager();

	        //transfer money
	        $from = $em->getRepository('OTBackendBundle:User')->findOneByName($TransferToModel->from);
	        $to = $em->getRepository('OTBackendBundle:User')->findOneByName($TransferToModel->to);

        	if ($from==null){
	            $this->get('session')->getFlashBag()->add(
	            'warning',
	            $this->get('translator')->trans('Cannot find user: '.$TransferToModel->from));

	            return $this->redirect($this->generateUrl('admin_account_transactionrecord_list'));

	        }

	        if ($to==null){
	            $this->get('session')->getFlashBag()->add(
	            'warning',
	            $this->get('translator')->trans('Cannot find user: '.$TransferToModel->to));

	            return $this->redirect($this->generateUrl('admin_account_transactionrecord_list'));

	        }

	        $from->setAccountBalance($from->getAccountBalance() - $TransferToModel->amount);
	        $to->setAccountBalance($to->getAccountBalance() + $TransferToModel->amount);

	        //write transaction record
	        $tr = new TransactionRecord();
	        $tr->setNote($TransferToModel->note=''?'(Manual Transaction)':$TransferToModel->note);
	        $tr->setType('T');
	        $tr->setFrom($from);
	        $tr->setTo($to);
	        $tr->setTransactionId(uniqid('T'));
	        $tr->setAmount($TransferToModel->amount);
	        $tr->setCreatedTime(new \DateTime("now"));
	        $em->persist($tr);

	       	$em->flush();
	        

	        $this->get('session')->getFlashBag()->add(
	            'success',
	            $this->get('translator')->trans('Transaction finished successfully.')
	        );

	        return $this->redirect($this->generateUrl('admin_account_transactionrecord_list'));
	    }

        return $this->render('OTBackendBundle:TransactionRecord:admin_account_transfer.html.twig', array('form'=>$form->createView()));
    }
}

