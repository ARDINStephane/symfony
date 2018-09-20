<?php

namespace App\Applications\IPs\Listener;

use App\Applications\IPs\Manager\IPManager;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;

class VisitListener
{
    /**
     * @var IPManager
     */
    private $IPManager;

    public function __construct(
        IPManager$IPManager
    ) {
        $this->IPManager = $IPManager;
    }

    public function __invoke(GetResponseEvent $event)
    {
        $clientIP = $event->getRequest()->getClientIp();
        $this->IPManager->checkIP($clientIP);
    }
}