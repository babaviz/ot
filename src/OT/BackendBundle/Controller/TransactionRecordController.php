<?php

namespace OT\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OT\CoreBundle\Entity\TransactionHistory;
use OT\CoreBundle\Entity\User;

use OT\BackendBundle\Form\TransferToType;
use OT\BackendBundle\Form\Model\TransferTo;

class TransactionRecordController extends Controller
{
    public function adminAccountTranscationRecordListAction()
    {
    	$transactions = $this->getDoctrine()->getManager()->getRepository('OTBackendBundle:TransactionRecord')->findAll();
        return $this->render('OTBackendBundle:TransactionRecord:admin_account_transactionrecord_list.html.twig', array('transactions'=>$transactions));
    }

    public function adminAccountTransferAction()
    {
    	$TransferToModel = new TransferTo();
     	$form = $this->createForm(new TransferToType(), $TransferToModel);

        return $this->render('OTBackendBundle:TransactionRecord:admin_account_transfer.html.twig', array('form'=>$form->createView()));
    }
}

