<?php

namespace App\Applications\IPs\Cache;


use Symfony\Component\HttpFoundation\Cookie;
use Symfony\Component\HttpFoundation\Session\SessionInterface;

class ListIPCache
{
    /**
     * @var SessionInterface
     */
    private $session;

    public function  __construct(
        SessionInterface $session
    ) {
        $this->session = $session;
    }

    public function setCacheListIP(array $listIP)
    {
        if(empty($this->session->get('listIPCached'))) {
            $this->setCookie($listIP);
        } else {
            $cookie = $this->session->get('listIPCached');

            if($cookie->getExpiresTime() > time()) {
                $listIPCached = $cookie->getValue();

                $listIP = $this->jsonDecodeListIP($listIPCached);

                return $listIP;
            } else {
                $this->setCookie($listIP);
            }
        }

        return $listIP;
    }

    private function setCookie(array $listIP)
    {
        $jsonListIP = $this->jsonEncodeListIP($listIP);
        $cookie = new Cookie(
            'listIPCached',
            $jsonListIP,
            time() + (30 * 60)
        );
        $this->session->set('listIPCached',$cookie);
    }

    private function jsonEncodeListIP(array $listIP): string
    {
        $jsonListIP = '';
        foreach($listIP as $IP) {
            $jsonListIP = $jsonListIP . '}{' . json_encode($IP->toArray());
        }

        return $jsonListIP;
    }

    private function jsonDecodeListIP(string $jsonListIP): array
    {
        $explode = explode('}{',$jsonListIP);

        $listIP = [];
        foreach ($explode as $jsonIP) {
            $listIP[] = json_decode($jsonIP);
        }
        unset($listIP[0]);

        return $listIP;
    }
}