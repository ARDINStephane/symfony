<?php

namespace App\Applications\Security\DTO\Build;

use App\Applications\Common\Entity\User;
use App\Applications\Security\Cache\LoginByConfirmationLinkHelper;
use App\Applications\Security\DTO\UserDTO;

class UserDTOBuilder
{
    /**
     * @var LoginByConfirmationLinkHelper
     */
    private $helper;

    public function __construct(
        LoginByConfirmationLinkHelper $helper
    ) {
        $this->helper = $helper;
    }

    public function build(User $user): UserDTO
    {
        $password = $this->helper->getPassword();
        return new UserDTO(
            $user->getName(),
            $user->getNewEmail(),
            $password,
            $user->getToken()
        );
    }
}