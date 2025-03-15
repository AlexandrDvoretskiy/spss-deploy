<?php

namespace App\Controller\Web\SkillResult\Get\v1;

use App\Domain\Entity\SkillResult;
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

    #[Route(path: "api/skill-result/v1/", methods: ["GET"])]
    public function __invoke(Request $request): Response
    {
        $id = $request->query->get("id");
        if (is_numeric($id)) {
            $skillResult = $this->manager->findById($id);

            if ($skillResult instanceof SkillResult) {
                return new JsonResponse($skillResult->toArray());
            }
        }

        return new JsonResponse(null, Response::HTTP_NOT_FOUND);
    }

}