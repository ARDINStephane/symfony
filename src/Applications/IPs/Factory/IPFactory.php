<?php

namespace App\Applications\IPs\Factory;


use App\Applications\Common\Entity\IP;
use App\Applications\Common\Repository\IPRepository;

class IPFactory
{
    /**
     * @var IPRepository
     */
    private $repository;

    public function __construct(
        IPRepository $repository
    ) {
        $this->repository = $repository;
    }
    public function build(string $clientIP, int $nbVisit, \DateTime $lastVisit): IP
    {
        $IP = $this->repository->new();

        $IP->setIP($clientIP);
        $IP->setNbVisit($nbVisit);
        $IP->setLastVisit($lastVisit);

        return $IP;
    }
}