<?php

namespace App\Controller\Web\Lesson\Create\v1;

use App\Controller\Web\Lesson\Create\v1\Input\CreateLessonDTO;
use App\Controller\Web\Lesson\Create\v1\Output\CreatedLessonDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
class Controller
{
    public function __construct(
        private readonly ManagerInterface $manager,
    ) {
    }

    // #[IsGranted("ROLE_ADMIN")]
    #[Route(path: 'api/lesson/v1/', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CreateLessonDTO $createLessonDTO): CreatedLessonDTO
    {
        return $this->manager->create($createLessonDTO);
    }
}