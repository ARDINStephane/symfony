<?php

namespace App\Applications\Doctrine\Entity;

use App\Applications\Common\Entity\User;
use Symfony\Component\Security\Core\User\UserInterface;

class DoctrineUser implements UserInterface, User
{
    /** @var int */
    private $id;
    /** @var string */
    private $name;
    /** @var string */
    private $email;
    /** @var string */
    private $newEmail;
    /** @var string */
    private $password;
    /** @var string */
    private $salt;
    /** @var array */
    private $roles;
    /** @var string */
    private $token;

    public function __construct()
    {
        $this->roles = ['ROLE_INCOMPLETE'];
    }

    public function eraseCredentials(){}

    /**
     * @param User $user
     * @return bool
     */
    public function is(User $user): bool
    {
        return $this->getId() === $user->getId();
    }

    /**
     * @return int
     */
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->newEmail;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return string
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getEmail(): ?string
    {
        return $this->email;
    }

    /**
     * @param string $email
     */
    public function setEmail(?string $email): void
    {
        $this->email = $email;
    }

    /**
     * @return string
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getSalt(): ?string
    {
        return $this->salt;
    }

    /**
     * @param string $salt
     */
    public function setSalt(string $salt): void
    {
        $this->salt = $salt;
    }

    /**
     * @return array
     */
    public function getRoles(): ?array
    {
        return $this->roles;
    }

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    /**
     * @return mixed
     */
    public function getNewEmail(): ?string
    {
        return $this->newEmail;
    }

    /**
     * @param mixed $newEmail
     */
    public function setNewEmail(?string $newEmail): void
    {
        $this->newEmail = $newEmail;
    }

    /**
     * @return string
     */
    public function getToken(): ?string
    {
        return $this->token;
    }

    /**
     * @param string $token
     */
    public function setToken(string $token): void
    {
        $this->token = $token;
    }

    /**
     * @return string
     */
    public function __toString(): string
    {
        return (string) $this->newEmail;
    }
}
