<?php

namespace App\Controller\Web\GetToken\v1;

use App\Application\Security\AuthService;
use App\Controller\Exception\AccessDeniedException;
use App\Controller\Exception\UnauthorizedException;
use Symfony\Component\HttpFoundation\Request;

class Manager
{
    public function __construct(private readonly AuthService $authService)
    {
    }

    /**
     * @throws AccessDeniedException
     * @throws UnauthorizedException
     */
    public function getToken(Request $request): string
    {
        $login = $request->getUser();
        $password = $request->getPassword();

        if (!$login || !$password) {
            throw new UnauthorizedException();
        }
        if (!$this->authService->isCredentialsValid($login, $password)) {
            throw new AccessDeniedException();
        }

        return $this->authService->getToken($login);
    }
}