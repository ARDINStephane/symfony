<?php

namespace App\Applications\Doctrine\Repository;

use App\Applications\Common\Repository\UserRepository;
use App\Applications\Doctrine\Entity\DoctrineUser;

class DoctrineUserRepository extends DoctrineBaseRepository implements UserRepository
{
    protected $class = DoctrineUser::class;
}