<?php

namespace App\Controller\Web\Skill\Batch\v1;

use App\Controller\Web\Skill\Batch\v1\Input\BatchDTO;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        public readonly Manager $manager,
    ) {
    }

    #[Route(path: '/api/skill/v1/batch', name: 'batch', methods: ['POST'])]
    public function batch(#[MapRequestPayload] BatchDTO $batchDTO): JsonResponse
    {
        return new JsonResponse(["count" => $this->manager->batch($batchDTO)]);
    }
}