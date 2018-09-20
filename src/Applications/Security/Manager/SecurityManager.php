<?php

namespace App\Applications\Security\Manager;

use App\Applications\Common\Controller\BaseController;
use App\Applications\Common\Entity\User;
use App\Applications\Common\Repository\UserRepository;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class SecurityManager
{
    /**
     * @var UserRepository
     */
    private $userRepository;
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(
        UserRepository $userRepository,
        SessionInterface $session
    ) {
        $this->userRepository = $userRepository;
        $this->session = $session;
    }

    public function newEmailCheck(User $user): bool
    {
        $email = $user->getEmail();
        $newEmail = $user->getNewEmail();
        if ($newEmail == $email) {
            return false;
        }

        $this->setEmailChangeToken($user, $newEmail);
        $this->userRepository->save($user);

        return true;
    }

    public function setEmailChangeToken(User $user, $newEmail): User
    {
        $token = \urlencode(random_bytes(25));
        $user->setToken($token);
        $user->setNewEmail($newEmail);

        return $user;
    }

    public function checkIfEmailExist(string $email): bool
    {
        $user = $this->userRepository->findBy([
            'email' => $email
        ]);

        $incompleteUser = $this->userRepository->findBy([
            'newEmail' => $email
        ]);
        if($user && $incompleteUser) {
            $this->session->getFlashBag()->add(BaseController::FLASH_INFO, "Il existe déjà un compte pour cet Email");

            return true;
        }
        elseif($user | $incompleteUser) {
            if($incompleteUser) {
                $this->session->getFlashBag()->add(BaseController::FLASH_INFO, "Cette adresse mail existe déjà mais n'est pas encore validée");
            }

            return true;
        } else {
            return false;
        }
    }
}