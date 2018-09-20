<?php

namespace App\Applications\Internationalisation\Controller;


use App\Applications\Common\Controller\BaseController;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Routing\Matcher\UrlMatcher;
use Symfony\Component\Routing\Matcher\UrlMatcherInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class InternationalisationController extends BaseController
{
    use TargetPathTrait;

    const FR = 'fr';
    const EN = 'en';
    /**
     * @var SessionInterface
     */
    private $session;
    /**
     * @var UrlGeneratorInterface
     */
    private $urlGenerator;
    /**
     * @var UrlMatcherInterface
     */
    private $matcher;

    public function __construct(
        SessionInterface $session,
        UrlGeneratorInterface $urlGenerator,
        UrlMatcherInterface $matcher
    ) {
        $this->session = $session;
        $this->urlGenerator = $urlGenerator;
        $this->matcher = $matcher;
    }

    /**
     * @Route("/set-lang", name="set_lang")
     */
    public function setLang(Request $request)
    {
        if($request->getLocale() == self::FR) {
            $request->setLocale(self::EN);
            $locale = self::EN;
        } else {
            $request->setLocale(self::FR);
            $locale = self::FR;
        }

        $lastURL = $_SERVER['HTTP_REFERER'];
        $explodedURL = explode('/', $lastURL);
        if(empty($explodedURL[5])){
            $parameter = '';
        } else {
            $parameter = '/' . $explodedURL[5];
        }
        $urlBuild = $explodedURL[0] . '//' . $explodedURL[2] . '/' . $locale  . '/' . $explodedURL[4] . $parameter;

        urlencode($urlBuild);

        return $this->redirect($urlBuild);
    }
}