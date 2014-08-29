<?php

namespace OT\BackendBundle\Form\Model;

use Symfony\Component\Validator\Constraints as Assert;

class ForceChangePassword

{
	
    public $username;

    /**
     * @Assert\Length(
     *     min = 6,
     *     minMessage = "Password should be at least 6 characters long"
     * )
     */
     public $newPassword;

}
