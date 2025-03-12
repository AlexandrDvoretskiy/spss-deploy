<?php

namespace App\Controller\Web\User\Get\v1;

use App\Domain\Entity\User;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager,
    ) {
    }

    #[Route(path: 'api/user/v1/', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $userId = $request->query->get("id");
        if (is_numeric($userId)) {
            $user = $this->manager->getUserById($userId);

            if ($user instanceof User) {
                return new JsonResponse($user->toArray());
            }
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}