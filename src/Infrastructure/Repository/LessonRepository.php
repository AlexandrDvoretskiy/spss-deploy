<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Lesson;
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
}