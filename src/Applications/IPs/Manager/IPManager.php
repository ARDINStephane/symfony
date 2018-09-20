<?php

namespace App\Applications\IPs\Manager;

use App\Applications\Common\Repository\IPRepository;
use App\Applications\IPs\Factory\IPFactory;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class IPManager
{
    const FIRST_VISIT = 1;

    /**
     * @var IPRepository
     */
    private $IPRepository;
    /**
     * @var IPFactory
     */
    private $IPFactory;

    private $check = true;
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(
        IPRepository $IPRepository,
        IPFactory $IPFactory,
        SessionInterface $session
    ) {
        $this->IPRepository = $IPRepository;
        $this->IPFactory = $IPFactory;
        $this->session = $session;
    }

    public function checkIP(string $clientIP)
    {
        $IP = $this->IPRepository->findBy([
            'IP' => $clientIP
        ]);
        $lastVisit = $this->setLastVisit();

        if($IP){
            if($this->session->isStarted() == true){
                return;
            } else {
                $IP = $IP[0];
                $IP->setLastVisit($lastVisit);
                $nbVisit = $IP->getNbVisit();
                $nbVisit += 1;
                $IP->setNbVisit($nbVisit);
            }
        } else {
            $IP = $this->IPFactory->build($clientIP, self::FIRST_VISIT, $lastVisit);
        }

        $this->IPRepository->save($IP);
    }

    private function setLastVisit(): \DateTime
    {
        $lastVisit = new \DateTime();

        return $lastVisit;
    }
}