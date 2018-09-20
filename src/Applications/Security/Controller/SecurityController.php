<?php

namespace App\Applications\Security\Controller;

use App\Applications\Common\Controller\BaseController;
use App\Applications\Common\Entity\User;
use App\Applications\Common\Repository\UserRepository;
use App\Applications\Mailer\Manager\MailingManager;
use App\Applications\Security\Cache\LoginByConfirmationLinkHelper;
use App\Applications\Security\Cache\TargetPathHelper;
use App\Applications\Security\DTO\Build\UserDTOBuilder;
use App\Applications\Security\Factory\UserFactory;
use App\Applications\Security\Form\RegisterType;
use App\Applications\Security\Manager\SecurityManager;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;
use Symfony\Component\Security\Core\Authentication\Token\UsernamePasswordToken;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Webmozart\Assert\Assert;

class SecurityController extends BaseController
{
    /**
     * @var UserRepository
     */
    private $repository;
    /**
     * @var UserFactory
     */
    private $factory;
    /**
     * @var UserDTOBuilder
     */
    private $userDTOBuilder;
    /**
     * @var MailingManager
     */
    private $mailingManager;
    /**
     * @var TokenStorageInterface
     */
    private $tokenStorage;
    /**
     * @var SecurityManager
     */
    private $securityManager;
    /**
     * @var LoginByConfirmationLinkHelper
     */
    private $helper;
    /**
     * @var AuthenticationUtils
     */
    private $authenticationUtils;
    /**
     * @var TargetPathHelper
     */
    private $targetPathHelper;

    private $baseUrl;

    public function __construct(
        UserRepository $repository,
        UserFactory $factory,
        SecurityManager $securityManager,
        UserDTOBuilder $userDTOBuilder,
        MailingManager $mailingManager,
        TokenStorageInterface $tokenStorage,
        LoginByConfirmationLinkHelper $helper,
        AuthenticationUtils $authenticationUtils,
        TargetPathHelper $targetPathHelper
    ) {
        $this->repository = $repository;
        $this->factory = $factory;
        $this->userDTOBuilder = $userDTOBuilder;
        $this->mailingManager = $mailingManager;
        $this->tokenStorage = $tokenStorage;
        $this->securityManager = $securityManager;
        $this->helper = $helper;
        $this->authenticationUtils = $authenticationUtils;
        $this->targetPathHelper = $targetPathHelper;
    }

    /**
     * @required
     */
    public function setDefaultId(ParameterBagInterface $parameterBag)
    {
        $this->baseUrl = $parameterBag->get('base_url');
    }

    /**
     * @Route("/register", name="register")
     */
    public function register(Request $request)
    {
        $user = $this->repository->new();

        $form = $this->createForm(RegisterType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $firstPassword = $form->getData()->getPassword('first');
            $secondPassword = $form->getData()->getPassword('second');
            $email = $form->getData()->getNewEmail();
            if($email) {
                $check = $this->securityManager->checkIfEmailExist($email);

                if($check) {

                    return $this->render('security/register.html.twig', array(
                        'user' => $user,
                        'form' => $form->createView()
                    ));
                }
            }

            if($firstPassword !== $secondPassword) {
                $this->addFlash(self::FLASH_INFO, 'Erreur mot de passe');

                return $this->render('security/register.html.twig', array(
                    'user' => $user,
                    'form' => $form->createView(),
                ));
            } else {
                $this->helper->setPassword($user->getPassword());

                $user = $this->factory->build($user);
                $this->helper->setUsername($user->getNewEmail());


                $this->confirmMail($user);
                return $this->redirectToRoute('login', [
                    'email' => $user->getEmail()
                ]);
            }
        }

        return $this->render('security/register.html.twig', [
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/login", name="login")
     */
    public function login(Request $request)
    {
        if ($this->isGranted('ROLE_USER')) {
            return $this->redirectToRoute('list_ip');
        }

        $register = $this->baseUrl . $this->generateUrl('register');
        if(!empty($_SERVER['HTTP_REFERER']) && $_SERVER['HTTP_REFERER'] != $register) {
            $targetPath = $_SERVER['HTTP_REFERER'];

            if ($this->isGranted('ROLE_INCOMPLETE')) {
                $this->targetPathHelper->set($targetPath);
                $user = $this->getUser();

                $this->generateLink($user);
                $this->addFlash(self::FLASH_INFO, 'Merci de cliquer sur le lien de confirmation qui vient de vous etre envoyé afin de profiter de toutes les fonctionnalités');
            } else {
                $this->addFlash(self::FLASH_INFO, 'Pour continuer, merci de vous connecter ou de vous enregister');
            }
        }

            $error = $this->authenticationUtils->getLastAuthenticationError();

        $email = $this->authenticationUtils->getLastUsername();

        return $this->render('security/login.html.twig', array(
            'last_username' => $email,
            'error' => $error
        ));
    }

    /**
     * @Route("/logout", name="logout")
     */
    public function logout()
    {
        return $this->redirectToRoute('login');
    }

    /**
     * @Route("/confirm-email/{token}", name="confirm_email")
     */
    public function saveEmail($token)
    {
        $tokenUser = $this->repository->findOneBy(['token' => $token]);
        Assert::notEmpty($tokenUser, 'tokenUser is empty');

        if (!empty($this->getUser()) && $tokenUser->is($this->getUser())) {
            $tokenUser->setEmail($tokenUser->getNewEmail());
            $tokenUser->setRoles(['ROLE_USER']);
            $this->repository->save($tokenUser);

            $token = new UsernamePasswordToken(
                $tokenUser,
                null,
                'main',
                $tokenUser->getRoles()
            );
            $this->tokenStorage->setToken($token);

            $this->addFlash(self::FLASH_INFO, 'Votre email a bien été enregistré');

            $this->helper->setPassword('');
            $this->helper->setUsername('');

            return $this->redirectToRoute('list_ip');
        } else {
            Assert::notEmpty($tokenUser, 'User is empty');

            $this->addFlash(self::FLASH_INFO, "Merci de vous connecter et de cliquer sur le nouveau lien qui vous sera envoyé");

            return $this->redirectToRoute('login');
        }
    }

    protected function confirmMail(User $user): void
    {
        if ($this->securityManager->newEmailCheck($user)) {
            $this->tokenStorage->getToken()->setUser($user);

            $this->generateLink($user);
        } else {
            $this->addFlash(self::FLASH_INFO, "Veuillez confirmer votre adresse Email en cliquant sur
                 le lien qui vous à été envoyé");
        }
    }

    protected function generateLink(User $user): void
    {
        $userDTO = $this->userDTOBuilder->build($user);
        $this->mailingManager->emailConfirmationMail($userDTO);
    }


}