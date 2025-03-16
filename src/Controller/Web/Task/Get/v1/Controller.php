<?php

namespace App\Controller\Web\Task\Get\v1;

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

    #[IsGranted("ROLE_VIEW")]
    #[Route(path: "api/task/v1/", methods: ["GET"])]
    public function __invoke(Request $request): Response
    {
        $id = $request->query->get("id");
        if (is_numeric($id)) {
            $task = $this->manager->findById($id);

            if ($task instanceof Task) {
                return new JsonResponse($task->toArray());
            }
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

}