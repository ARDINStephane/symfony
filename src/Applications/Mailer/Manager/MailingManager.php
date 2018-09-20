<?php

namespace App\Applications\Mailer\Manager;


use App\Applications\Security\DTO\UserDTO;
use Symfony\Component\Templating\EngineInterface;

class MailingManager
{
    /**
     * @var \Swift_Mailer
     */
    private $mailer;
    /**
     * @var EngineInterface
     */
    private $templating;

    public function __construct(
        \Swift_Mailer $mailer,
        EngineInterface $templating
    ) {
        $this->mailer = $mailer;
        $this->templating = $templating;
    }

    public function emailConfirmationMail(UserDTO $userDTO): void
    {
        $message = (new \Swift_Message('Hello'))
            ->setFrom('stephane.ardin@gmail.com')
            ->setTo($userDTO->getEmail())
            ->setBody(
                $this->templating->render(
                    'email/confirmation_link.html.twig',
                    ['user' => $userDTO]
                ),
                'text/html'
            );
        $this->mailer->send($message);
    }
}