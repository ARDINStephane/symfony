<?php

namespace App\Applications\Common\Entity;

interface IP
{
    /**
     * @return mixed
     */
    public function getIP();

    /**
     * @param mixed $IP
     */
    public function setIP(string $IP): void;
}