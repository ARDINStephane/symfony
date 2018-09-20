<?php

namespace App\Applications\Security\Listener;


use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;

class HomeBaseUrlListener implements EventSubscriberInterface
{
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;

    public function __construct(
        UrlGeneratorInterface $urlGenerator
    )
    {
        $this->urlGenerator = $urlGenerator;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => [['homeRedirect', 100]],
        );
    }

// TODO:  try to find better solution for login redirect
    public function homeRedirect(GetResponseEvent $event)
    {
        if ($_SERVER['REQUEST_URI'] == '/') {
            $url = $this->urlGenerator->generate('list_ip');
            $response = new RedirectResponse($url);
            $event->setResponse($response);
        }
    }
}
