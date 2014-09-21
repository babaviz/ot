<?php

namespace OT\BackendBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class User
{

     /**
      * @Assert\NotBlank()
      */
     public $username;

     /**
      * @Assert\NotBlank()
      */
     public $name;

     /**
      * @Assert\NotBlank()
      */
     public $password;

     /**
      * @Assert\Email(message = "The email '{{ value }}' is not a valid email.",
      *         checkMX = true)
      */
     public $email;

     /**
      * @Assert\NotBlank()\Type(type="numeric",message="You must enter a number as amount.")
      */
     public $account_balance;

     /**
      * @Assert\NotBlank()
      */
     public $timezone;

}
