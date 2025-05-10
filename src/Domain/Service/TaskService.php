<?php

namespace App\Domain\Service;

use App\Domain\Entity\Task;
use App\Domain\Event\TaskIsCreatedEvent;
use App\Domain\Event\TaskIsDeletedEvent;
use App\Domain\Model\CreateTaskModel;
use App\Infrastructure\Repository\TaskRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class TaskService
{
    public function __construct(
        private readonly TaskRepository $taskRepository,
        private readonly LessonService $lessonService,
        private readonly EventDispatcherInterface $eventDispatcher
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

        $this->eventDispatcher->dispatch(
            new TaskIsCreatedEvent($task->getId(), $task->getTitle())
        );

        return $task;
    }

    public function findById(int $id): Task
    {
       return $this->taskRepository->find($id);
    }

    public function deleteTaskIfExists(int $id): bool
    {
        $result = $this->taskRepository->deleteTaskIfExists($id);
        if ($result) {
            $this->eventDispatcher->dispatch(
                new TaskIsDeletedEvent($id)
            );
        }
        return $result;
    }

    public function updateLesson(int $id, int $lesson): array
    {
        if ($this->taskRepository->updateLesson($id, $lesson)) {
            return $this->findById($id)->toArray();
        }

        return []; // Не уверен, что так можно делать
    }


}