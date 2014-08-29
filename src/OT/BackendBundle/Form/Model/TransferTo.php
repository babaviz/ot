<?php

namespace OT\BackendBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class TransferTo
{

     public $type;

     public $from;

     /**
      * @Assert\NotBlank()
      */
     public $to;

     /**
      * @Assert\Type(type="numeric",message="You must enter a number as amount.")
      */
     public $amount;

     /**
      * @Assert\Type(type="string")
      */
     public $note;

     public $created_time;

     public $transaction_id;

     public $hash;
}
