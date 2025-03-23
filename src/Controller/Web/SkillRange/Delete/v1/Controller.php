<?php

namespace App\Controller\Web\SkillRange\Delete\v1;

use App\Domain\Entity\Task;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    ) {
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route(path: "api/skill-range/v1/{id}/", requirements:["id" => "\d+"], methods: ["DELETE"])]
    public function __invoke(int $id): Response
    {
        if ($result = $this->manager->deleteSkillRangeIfExists($id)) {
            return new JsonResponse(['success' => $result]);
        }

        return new JsonResponse(['success' => $result]);
    }

}