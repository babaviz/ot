<?php

namespace OT\BackendBundle\Form\Model;

use Symfony\Component\Security\Core\Validator\Constraints as SecurityAssert;
use Symfony\Component\Validator\Constraints as Assert;

class ChangePassword
{
    /**
     * @SecurityAssert\UserPassword(
     *     message = "Wrong value for your current password"
     * )
     */
     public $oldPassword;

    /**
     * @Assert\Length(
     *     min = 6,
     *     minMessage = "Password should be at least 6 characters long"
     * )
     */
     public $newPassword;
}
