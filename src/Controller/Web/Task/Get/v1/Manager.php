<?php

namespace App\Controller\Web\Task\Get\v1;

use App\Domain\Entity\Task;
use App\Domain\Service\TaskService;

class Manager
{
    public function __construct(
        private readonly TaskService $taskService
    )
    {
    }

    public function findById(int $id): Task
    {
        return $this->taskService->findById($id);
    }
}