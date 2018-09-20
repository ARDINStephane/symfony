<?php

namespace App\Applications\Common\Entity;

use Symfony\Component\Security\Core\User\UserInterface;

interface User extends UserInterface
{
    public function eraseCredentials();

    /**
     * @return int
     */
    public function getId(): ?int;

    public function is(User $user): bool;

    public function getUsername(): ?string;

    /**
     * @param int $id
     */
    public function setId(int $id): void;

    /**
     * @return string
     */
    public function getName(): ?string;

    /**
     * @param string $name
     */
    public function setName(string $name): void;

    /**
     * @return string
     */
    public function getEmail(): ?string;

    /**
     * @param string $email
     */
    public function setEmail(?string $email): void;

    /**
     * @return string
     */
    public function getPassword(): ?string;

    /**
     * @param string $password
     */
    public function setPassword(string $password): void;

    /**
     * @return string
     */
    public function getSalt(): ?string;

    /**
     * @param string $salt
     */
    public function setSalt(string $salt): void;

    /**
     * @return array
     */
    public function getRoles(): ?array;

    /**
     * @param array $roles
     */
    public function setRoles(array $roles): void;

    /**
     * @return mixed
     */
    public function getNewEmail(): ?string;

    /**
     * @param mixed $newEmail
     */
    public function setNewEmail(?string $newEmail): void;

    /**
     * @return string
     */
    public function getToken(): ?string;

    /**
     * @param string $token
     */
    public function setToken(string $token): void;

    /**
     * @return string
     */
    public function __toString(): string;
}