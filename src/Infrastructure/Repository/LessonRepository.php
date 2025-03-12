<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Lesson;
use App\Domain\Entity\User;
use Doctrine\ORM\AbstractQuery;

/**
 * @extends AbstractRepository<Lesson>
 */
class LessonRepository extends AbstractRepository
{
    public function create(Lesson $lesson): int
    {
        return $this->store($lesson);
    }

    public function findById(int $id): ?Lesson
    {
        return $this->entityManager->getRepository(Lesson::class)->find($id);
    }

    public function deleteLessonIfExists(int $id): bool
    {
        $lesson = $this->findById($id);

        if ($lesson instanceof Lesson) {
            $this->remove($lesson);
            $this->flush();

            return true;
        }

        return false;
    }
}