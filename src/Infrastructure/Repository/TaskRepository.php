<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Task;
use Doctrine\ORM\AbstractQuery;

/**
 * @extends AbstractRepository<Task>
 */
class TaskRepository extends AbstractRepository
{
    public function create(Task $task): int
    {
        return $this->store($task);
    }
}