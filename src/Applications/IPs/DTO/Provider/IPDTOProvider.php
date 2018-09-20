<?php

namespace App\Applications\IPs\DTO\Provider;


use App\Applications\IPs\DTO\Builder\IPDTOBuilder;

class IPDTOProvider
{
    /**
     * @var IPDTOBuilder
     */
    private $builder;

    public function __construct(
        IPDTOBuilder $builder
    ) {
        $this->builder = $builder;
    }

    public function provideIPDTO(array $IPs): array
    {
        $IPsDTO = [];
        foreach ($IPs as $IP) {
            $IPsDTO[] = $this->builder->build($IP);
        }

        return $IPsDTO;
    }
}