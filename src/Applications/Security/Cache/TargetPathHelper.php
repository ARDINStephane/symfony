<?php

namespace App\Applications\Security\Cache;

use Symfony\Component\HttpFoundation\Session\SessionInterface;

class TargetPathHelper
{
    const KEY = 'targetPath';
    /**
     * @var SessionInterface
     */
    private $session;

    public function __construct(
        SessionInterface $session
    ) {
        $this->session = $session;
    }

    public function set(string $url)
    {
        $this->session->set(self::KEY , $url);
    }

    public function get(): ?string
    {
        return $this->session->get(self::KEY);
    }
}