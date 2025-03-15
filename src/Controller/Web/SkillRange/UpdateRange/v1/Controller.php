<?php

namespace App\Controller\Web\SkillRange\UpdateRange\v1;

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
        path: "api/skill-range/v1/{id}/{skillRange}/",
        requirements:[
            "id" => "\d+",
            "skillRange" => "\d+"
        ],
        methods: ["PATCH"])
    ]
    public function __invoke(int $id, int $skillRange): Response
    {
        return new JsonResponse(
            $this->manager->updateSkillRange($id, $skillRange)
        );
    }

}