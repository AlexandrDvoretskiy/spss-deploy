<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Task;
use App\Domain\Model\TaskModel;
use App\Domain\Repository\TaskRepositoryInterface;
use Psr\Cache\CacheItemPoolInterface;
use Psr\Cache\InvalidArgumentException;

/**
 * Добавляем кэширование к базовой реализации TweetRepository
 */
class TaskRepositoryCacheDecorator implements TaskRepositoryInterface
{

    public function __construct(
        private readonly TaskRepository $taskRepository,
        private readonly CacheItemPoolInterface $cacheItemPool,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function create(Task $task): int
    {
        return $this->taskRepository->create($task);
    }

    /**
     * @throws InvalidArgumentException
     */
    public function getTasksPaginated(int $page, int $perPage): array
    {
        $tasksItem = $this->cacheItemPool->getItem($this->getCacheKey($page, $perPage));

        if (!$tasksItem->isHit()) {
            $tasks = $this->taskRepository->getTasksPaginated($page, $perPage);

            $tasksItem->set(
                array_map(
                    static fn (Task $task): TaskModel => new TaskModel(
                        $task->getId(),
                        $task->getTitle(),
                        $task->getLessonInfo(),
                        $task->getCreatedAt()->format('Y-m-d H:i:s'),
                    ),
                    $tasks
                )
            );

            $this->cacheItemPool->save($tasksItem);
        }

        return $tasksItem->get();
    }

    public function getCacheKey(int $page, int $perPage): string
    {
        return "tasks_{$page}_$perPage";
    }
}