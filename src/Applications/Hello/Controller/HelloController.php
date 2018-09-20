<?php

namespace App\Applications\Hello\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Translation\TranslatorInterface;

class HelloController extends Controller
{
    const TEST = 'Twig is a modern template engine for PHP';
    const HELLO = 'Hello testTechnique !';
    /**
     * @var TranslatorInterface
     */
    private $translator;

    public function __construct(
        TranslatorInterface $translator
    ) {
        $this->translator = $translator;
    }

    /**
     * @Route("/", name="hello_testTechnique")
     */
    public function hello()
    {
        // other method for translation
        $hello = $this->translator->trans('header.hello');

        return $this->render('hello_testTechnique/hello_testTechnique.html.twig', ['hello' => $hello]);
    }

    /**
     * @Route("/twig", name="use_twig")
     */
    public function useTwig()
    {
        return $this->render('use_twig/use_twig.html.twig', ['test' => self::TEST]);
    }
}