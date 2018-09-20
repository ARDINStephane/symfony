<?php

namespace App\Applications\Doctrine\Repository;

use App\Applications\Common\Repository\IPRepository;
use App\Applications\Doctrine\Entity\DoctrineIP;

class DoctrineIPRepository extends DoctrineBaseRepository implements IPRepository
{
    protected $class = DoctrineIP::class;

    public function getListIP(): array
    {
        return $this->createQueryBuilder()
            ->orderBy('o.nbVisit', 'DESC')
            ->getQuery()
            ->getResult()
            ;
    }
}