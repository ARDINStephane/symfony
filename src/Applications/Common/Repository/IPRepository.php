<?php

namespace App\Applications\Common\Repository;

interface IPRepository extends BaseRepository
{
    public function getListIP(): array;
}