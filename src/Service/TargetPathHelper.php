<?php

namespace App\Service;

use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\RouterInterface;
use Symfony\Component\Security\Http\Util\TargetPathTrait;

class TargetPathHelper
{
    use TargetPathTrait;

    /**
     * @var RouterInterface
     */
    private $router;

    public function __construct(RouterInterface $router)
    {
        $this->router = $router;
    }

    public function redirectToTargetPath(SessionInterface $session, string $providerKey = "main")
    {
        if($targetPath = $this->getTargetPath($session, $providerKey)) {
            return new RedirectResponse($targetPath);
        }

        return new RedirectResponse($this->router->generate('app_homepage'));
    }

    public function setTargetPath(SessionInterface $session, string $providerKey, string $uri)
    {
        $this->saveTargetPath($session, $providerKey, $uri);
    }
}