<?php

namespace App\Controller\Web\Lesson\Get\v1;

use App\Domain\Entity\Lesson;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager,
    ) {
    }

    #[IsGranted("ROLE_VIEW")]
    #[Route(path: 'api/lesson/v1/', methods: ['GET'])]
    public function __invoke(Request $request): Response
    {
        $id = $request->query->get("id");
        if (is_numeric($id)) {
            $lesson = $this->manager->findById($id);

            if ($lesson instanceof Lesson) {
                return new JsonResponse($lesson->toArray());
            }
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }
}