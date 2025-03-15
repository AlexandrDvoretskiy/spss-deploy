<?php

namespace App\Controller\Web\Task\UpdateLesson\v1;

use App\Domain\Entity\Task;
use App\Domain\Service\TaskService;

class Manager
{
    public function __construct(
        private readonly TaskService $taskService
    )
    {
    }

    public function updateLesson(int $id, int $lesson): array
    {
        return $this->taskService->updateLesson($id, $lesson);
    }

}