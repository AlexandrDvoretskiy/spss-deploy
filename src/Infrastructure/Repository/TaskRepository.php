<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Lesson;
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

    public function find(int $id): Task
    {
        return $this->entityManager->getRepository(Task::class)->find($id);
    }

    public function deleteTaskIfExists(int $id): bool
    {
        $task = $this->find($id);

        if (is_object($task)) {
            $this->remove($task);
            $this->flush();

            return true;
        }

        return false;
    }

    public function updateLesson(int $id, int $lesson): bool
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->update(Task::class, 't')
            ->set('t.lesson', ':lesson')
            ->where(
                $queryBuilder->expr()->eq('t.id', ':id')
            )
            ->setParameter('lesson', $lesson)
            ->setParameter('id', $id);

        return $queryBuilder->getQuery()->execute();
    }

}