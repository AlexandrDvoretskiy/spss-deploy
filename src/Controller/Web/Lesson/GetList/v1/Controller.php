<?php

namespace App\Controller\Web\Lesson\GetList\v1;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapQueryParameter;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager,
    ) {
    }

    #[Route(path:'/api/lesson/v1/get-list', name: 'getList', methods: ['GET'])]
    public function getList(#[MapQueryParameter]int $page, #[MapQueryParameter]int $perPage): JsonResponse
    {
        return new JsonResponse(["lessons" => $this->manager->getList($page, $perPage)]);
    }
}