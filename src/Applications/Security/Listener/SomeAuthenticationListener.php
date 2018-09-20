<?php

namespace App\Applications\Security\Listener;

use App\Applications\Security\Cache\LoginByConfirmationLinkHelper;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\HttpKernel\KernelEvents;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\AuthenticationManagerInterface;
use Symfony\Component\HttpKernel\Event\GetResponseEvent;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;

class SomeAuthenticationListener implements EventSubscriberInterface
{
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;

    /**
     * @var AuthenticationManagerInterface
     */
    private $authenticationManager;

    /**
     * @var string Uniquely identifies the secured area
     */
    private $providerKey = 'main';
    /**
     * @var LoginByConfirmationLinkHelper
     */
    private $helper;
    /**
     * @var UrlGeneratorInterface
     */
    private $generator;

    public function __construct(
        AuthenticationManagerInterface $authenticationManager,
        TokenStorageInterface $tokenStorage,
        LoginByConfirmationLinkHelper $helper,
        UrlGeneratorInterface $generator

    ) {
        $this->authenticationManager = $authenticationManager;
        $this->tokenStorage = $tokenStorage;
        $this->helper = $helper;
        $this->generator = $generator;
    }

    public static function getSubscribedEvents()
    {
        return array(
            KernelEvents::REQUEST => 'handle',
        );
    }
    public function handle(GetResponseEvent $event)
    {
        $url = $this->generator->generate('login');
        if ($_SERVER['REQUEST_URI'] == $url) {
            if($this->helper->getPassword() && $this->helper->getUsername()) {
                $username = $this->helper->getUsername();
                $password = $this->helper->getPassword();
                $unauthenticatedToken = new UsernamePasswordToken(
                    $username,
                    $password,
                    $this->providerKey
                );

                $authenticatedToken = $this
                    ->authenticationManager
                    ->authenticate($unauthenticatedToken);
                $this->tokenStorage->setToken($authenticatedToken);
            }
        }
    }
}