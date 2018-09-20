<?php

namespace App\Applications\IPs\Controller;


use App\Applications\Common\Controller\BaseController;
use App\Applications\Common\Repository\IPRepository;
use App\Applications\IPs\Cache\ListIPCache;
use App\Applications\IPs\DTO\Builder\IPDTOBuilder;
use App\Applications\IPs\DTO\Provider\IPDTOProvider;
use Symfony\Component\Routing\Annotation\Route;

class IPController extends BaseController
{
    /**
     * @var IPRepository
     */
    private $repository;
    /**
     * @var IPDTOProvider
     */
    private $provider;
    /**
     * @var IPDTOBuilder
     */
    private $IPDTOBuilder;
    /**
     * @var ListIPCache
     */
    private $cache;

    public function __construct(
        IPRepository $repository,
        IPDTOProvider $provider,
        IPDTOBuilder $IPDTOBuilder,
        ListIPCache $cache
    ) {
        $this->repository = $repository;
        $this->provider = $provider;
        $this->IPDTOBuilder = $IPDTOBuilder;
        $this->cache = $cache;
    }

    /**
     * @Route("/list-ip", name="list_ip")
     */
    public function listIP()
    {
        $IPs = $this->repository->getListIP();

        $IPDTO = $this->provider->provideIPDTO($IPs);
        $listIPCache = $this->cache->setCacheListIP($IPDTO);

        return $this->render('IP/list_IP.html.twig',
            [
                'IPs' => $listIPCache
            ]
        );
    }

    /**
     * @Route("/show-ip/{id}", name="show_ip")
     */
    public function showIP(string $id)
    {
        $IP = $this->findByRepository($this->repository, $id);

        $IPDTO = $this->IPDTOBuilder->build($IP);

        return $this->render('IP/show_IP.html.twig',
            [
                'IP' => $IPDTO,
            ]
        );
    }
}