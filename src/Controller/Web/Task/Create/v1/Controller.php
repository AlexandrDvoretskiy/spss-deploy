<?php

namespace App\Controller\Web\Task\Create\v1;

use App\Controller\Web\Task\Create\v1\Input\CreateTaskDTO;
use App\Controller\Web\Task\Create\v1\Output\CreatedTaskDTO;
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

    // #[IsGranted("ROLE_ADMIN")]
    #[Route(path: "api/task/v1/", methods: ["POST"])]
    public function __invoke(#[MapRequestPayload] CreateTaskDTO $createTaskDTO): CreatedTaskDTO
    {
        return $this->manager->create($createTaskDTO);
    }

}