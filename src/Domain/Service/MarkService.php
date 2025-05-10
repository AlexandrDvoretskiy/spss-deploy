<?php

namespace App\Domain\Service;

use App\Domain\Entity\Mark;
use App\Domain\Event\MarkIsCreatedEvent;
use App\Domain\Model\CreateMarkModel;
use App\Infrastructure\Repository\MarkRepository;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

class MarkService
{
    public function __construct(
        private readonly MarkRepository $markRepository,
        private readonly UserService $userService,
        private readonly TaskService $taskService,
        private readonly EventDispatcherInterface $eventDispatcher
    )
    {
    }

    public function create(CreateMarkModel $createMarkModel): Mark
    {
        $mark = new Mark(
            $createMarkModel->mark,
            $this->userService->findUserById($createMarkModel->user),
            $this->taskService->findById($createMarkModel->task),
        );

        if ($this->markRepository->create($mark)) {
            $this->eventDispatcher->dispatch(
                new MarkIsCreatedEvent(
                    $mark->getUser()["id"],
                    $mark->getTask()["id"],
                    $mark->getMark(),
                )
            );
        }

        return $mark;
    }

    public function findById(int $id): Mark
    {
        return $this->markRepository->find($id);
    }

    public function deleteMarkIfExists(int $id): bool
    {
        return $this->markRepository->deleteMarkIfExists($id);
    }

    public function updateMark(int $id, int $mark): array
    {
        if ($this->markRepository->updateMark($id, $mark)) {
            return $this->findById($id)->toArray();
        }

        return ["success" => false];
    }
}