<?php

namespace App\Controller\Web\Task\List\v1;

use App\Controller\Web\Task\List\v1\Output\TaskDTO;
use App\Domain\Model\TaskModel;
use App\Domain\Service\TaskService;

class Manager
{
    public function __construct(
        private readonly TaskService $taskService
    ) {

    }

    public function getTasksPaginated(int $page, int $perPage): array
    {
        return array_map(
            static fn (TaskModel $task) => new TaskDTO(
                $task->id,
                $task->title,
                $task->lesson,
                $task->createdAt,
            ),
            $this->taskService->getTasksPaginated($page, $perPage)
        );
    }
}