<?php

namespace App\Domain\Service;

use App\Domain\Entity\Task;
use App\Domain\Model\CreateTaskModel;
use App\Infrastructure\Repository\TaskRepository;

class TaskService
{
    public function __construct(
        private readonly TaskRepository $taskRepository,
        private readonly LessonService $lessonService
    )
    {
    }

    public function create(CreateTaskModel $createTaskModel): Task
    {
        $lesson = $this->lessonService->findById($createTaskModel->lesson);

        $task = new Task(
            $createTaskModel->title,
            $lesson
        );

        $this->taskRepository->create($task);

        return $task;
    }

    public function findById(int $id): Task
    {
       return $this->taskRepository->find($id);
    }

    public function deleteTaskIfExists(int $id): bool
    {
        return $this->taskRepository->deleteTaskIfExists($id);
    }

    public function updateLesson(int $id, int $lesson): array
    {
        if ($this->taskRepository->updateLesson($id, $lesson)) {
            return $this->findById($id)->toArray();
        }

        return []; // Не уверен, что так можно делать
    }


}