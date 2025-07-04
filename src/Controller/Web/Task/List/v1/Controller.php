<?php

namespace App\Controller\Web\Task\List\v1;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    ) {
    }

    #[Route(path: "api/task/v1/list", name: "list", methods: ["GET"])]
    public function __invoke(#[MapQueryParameter]int $page, #[MapQueryParameter]int $perPage): Response
    {
        return new JsonResponse(['tasks' => $this->manager->getTasksPaginated($page, $perPage)]);
    }
}