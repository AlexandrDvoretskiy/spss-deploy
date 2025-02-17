<?php

namespace App\Domain\Service;

use App\Domain\Entity\Task;
use App\Infrastructure\Repository\TaskRepository;

class TaskService
{
    public function __construct(private readonly TaskRepository $taskRepository)
    {
    }

    public function create(): Task
    {

    }
}