<?php

namespace App\Controller\Web\Task\Create\v1;

use App\Controller\Web\Task\Create\v1\Input\CreateTaskDTO;
use App\Controller\Web\Task\Create\v1\Output\CreatedTaskDTO;
use App\Domain\Model\CreateTaskModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\TaskService;

class Manager
{
    public function __construct(
        private readonly ModelFactory $modelFactory,
        private readonly TaskService $taskService
    )
    {
    }

    public function create(CreateTaskDTO $createTaskDTO): CreatedTaskDTO
    {
        $createTaskModel = $this->modelFactory->makeModel(CreateTaskModel::class, $createTaskDTO->title, $createTaskDTO->lesson);
        $task = $this->taskService->create($createTaskModel);

        return new CreatedTaskDTO(
            $task->getId(),
            $task->getTitle(),
            $task->getLesson(),
            $task->getSkills(),
            $task->getMarks(),
            $task->getRanges(),
            $task->getSkillResults(),
            $task->getCreatedAt()->format("d.m.Y H:i:s"),
            $task->getUpdatedAt()->format("d.m.Y H:i:s"),
        );
    }
}