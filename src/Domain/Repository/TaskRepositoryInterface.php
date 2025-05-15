<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Task;
use App\Domain\Model\TaskModel;

interface TaskRepositoryInterface
{
    public function create(Task $task): int;

    /**
     * @return TaskModel
     */
    public function getTasksPaginated(int $page, int $perPage): array;
}