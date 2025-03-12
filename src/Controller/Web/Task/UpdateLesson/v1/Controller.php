<?php

namespace App\Controller\Web\Task\UpdateLesson\v1;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    ) {
    }

    #[Route(
        path: "api/task/v1/{id}/{lesson}/",
        requirements:[
            "id" => "\d+",
            "lesson" => "\d+"
        ],
        methods: ["PATCH"])
    ]
    public function __invoke(int $id, int $lesson): Response
    {
        return new JsonResponse(
            $this->manager->updateLesson($id, $lesson)
        );
    }

}