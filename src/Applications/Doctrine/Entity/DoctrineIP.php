<?php

namespace App\Applications\Doctrine\Entity;

use App\Applications\Common\Entity\IP;

/**
 * @ORM\Entity(repositoryClass="\App\Applications\Doctrine\Repository\DoctrineIPRepository")
 */
class DoctrineIP implements IP
{
    private $IP;
    /** @var int $id */
    private $id;
    /** @var int $id */
    private $nbVisit;
    /** @var \DateTime $id */
    private $lastVisit;
    /**
     * @return mixed
     */
    public function getIP()
    {
        return $this->IP;
    }

    /**
     * @param mixed $IP
     */
    public function setIP(string $IP): void
    {
        $this->IP = $IP;
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

    /**
     * @return int
     */
    public function getNbVisit(): int
    {
        return $this->nbVisit;
    }

    /**
     * @param int $nbVisit
     */
    public function setNbVisit(int $nbVisit): void
    {
        $this->nbVisit = $nbVisit;
    }

    /**
     * @return \DateTime
     */
    public function getLastVisit(): \DateTime
    {
        return $this->lastVisit;
    }

    /**
     * @param \DateTime $lastVisit
     */
    public function setLastVisit(\DateTime $lastVisit): void
    {
        $this->lastVisit = $lastVisit;
    }
}