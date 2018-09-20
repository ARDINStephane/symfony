<?php

namespace App\Applications\Common\Repository;

use Doctrine\ORM\QueryBuilder;

interface BaseRepository
{
    public function saveBatch(array $List): void;

    public function createQueryBuilder($alias = 'o', $indexBy = null): QueryBuilder;

    public function save($object): void;

    public function getClass(): string;

    public function new(...$args);
}