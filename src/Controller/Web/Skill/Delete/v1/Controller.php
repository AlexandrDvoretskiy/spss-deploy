<?php

namespace App\Controller\Web\Skill\Delete\v1;

use App\Domain\Entity\Skill;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager,
    ) {
    }

    #[Route(path: 'api/skill/v1/{id}/', requirements: ['id' => '\d+'], methods: ['DELETE'])]
    public function __invoke(int $id): Response
    {
        if ($result = $this->manager->deleteSkillIfExists($id)) {
            return new JsonResponse(['success' => $result]);
        }

        return new JsonResponse(['success' => $result]);
    }
}