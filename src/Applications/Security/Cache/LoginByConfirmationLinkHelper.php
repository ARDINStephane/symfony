<?php

namespace App\Applications\Security\Cache;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class LoginByConfirmationLinkHelper
{
    const USERNAME = 'username';
    const PASSWORD = 'password';

    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(
        SessionInterface $session
    ) {
        $this->session = $session;
    }

    public function setUsername(?string $username): void
    {
        $this->session->set(self::USERNAME, $username);
    }

    public function setPassword(?string $password): void
    {
        $this->session->set(self::PASSWORD, $password);
    }

    public function getUsername(): ?string
    {
        return $this->session->get(self::USERNAME);
    }

    public function getPassword(): ?string
    {
        return $this->session->get(self::PASSWORD);
    }
}