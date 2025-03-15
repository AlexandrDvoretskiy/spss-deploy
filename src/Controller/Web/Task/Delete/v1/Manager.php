<?php

namespace App\Controller\Web\Task\Delete\v1;

use App\Domain\Entity\Task;
use App\Domain\Service\TaskService;

class Manager
{
    public function __construct(
        private readonly TaskService $taskService
    )
    {
    }

    public function deleteTaskIfExists(int $id): bool
    {
        return $this->taskService->deleteTaskIfExists($id);
    }

}