<?php

namespace App\Applications\IPs\DTO\Builder;


use App\Applications\Common\Entity\IP;
use App\Applications\IPs\DTO\IPDTO;
use Symfony\Component\Routing\RouterInterface;

class IPDTOBuilder
{
    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(
        RouterInterface $router
    ) {
        $this->router = $router;
    }

    public function build(IP $IP): IPDTO
    {
        $IPURL = $this->router->generate('show_ip', array('id' => $IP->getId()));

        return new IPDTO(
            $IP->getId(),
            $IP->getIP(),
            $IP->getNbVisit(),
            $IP->getLastVisit(),
            $IPURL
        );
    }
}