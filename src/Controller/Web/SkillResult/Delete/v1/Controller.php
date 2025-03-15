<?php

namespace App\Controller\Web\SkillResult\Delete\v1;

use App\Domain\Entity\Task;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    ) {
    }

    #[Route(path: "api/skill-result/v1/{id}/", requirements:["id" => "\d+"], methods: ["DELETE"])]
    public function __invoke(int $id): Response
    {
        if ($result = $this->manager->deleteSkillResultIfExists($id)) {
            return new JsonResponse(['success' => $result]);
        }

        return new JsonResponse(['success' => $result]);
    }

}