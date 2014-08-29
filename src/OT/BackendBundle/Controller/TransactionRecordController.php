<?php

namespace OT\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use OT\CoreBundle\Entity\TransactionHistory;
use OT\CoreBundle\Entity\User;

class TransactionRecordController extends Controller
{
    public function adminAccountTranscationRecordListAction()
    {
    	$transactions = $this->getDoctrine()->getManager()->getRepository('OTBackendBundle:TransactionRecord')->findAll();
        return $this->render('OTBackendBundle:TransactionRecord:admin_account_transactionrecord_list.html.twig', array('transactions'=>$transactions));
    }
}

