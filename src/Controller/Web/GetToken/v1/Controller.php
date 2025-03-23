<?php

namespace App\Controller\Web\GetToken\v1;

use App\Controller\Exception\AccessDeniedException;
use App\Controller\Exception\UnauthorizedException;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(private readonly Manager $manager) {
    }

    /**
     * @throws UnauthorizedException
     * @throws AccessDeniedException
     */
    #[Route(path: 'api/get-token/v1/', methods: ['POST'])]
    public function __invoke(Request $request): Response
    {
        return new JsonResponse([
            'token' => $this->manager->getToken($request)
        ]);
    }
}