<?php

namespace App\Applications\Security\Factory;

use App\Applications\Common\Entity\User;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class UserFactory
{
    /**
     * @var UserPasswordEncoderInterface
     */
    private $encoder;

    public function __construct(
        UserPasswordEncoderInterface $encoder
    ) {
        $this->encoder = $encoder;
    }

    public function build(User $user): User
    {
        $salt = uniqid(mt_rand(), true);

        $user->setSalt($salt);
        $password = $this->encoder->encodePassword($user, $user->getPassword());
        $user->setPassword($password);

        return $user;
    }
}