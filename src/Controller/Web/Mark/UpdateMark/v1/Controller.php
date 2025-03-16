<?php

namespace App\Controller\Web\Mark\UpdateMark\v1;

use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    ) {
    }

    #[IsGranted("ROLE_EDIT")]
    #[Route(
        path: "api/mark/v1/{id}/{mark}/",
        requirements:[
            "id" => "\d+",
            "mark" => "\d+"
        ],
        methods: ["PATCH"])
    ]
    public function __invoke(int $id, int $mark): Response
    {
        return new JsonResponse(
            $this->manager->updateMark($id, $mark)
        );
    }

}