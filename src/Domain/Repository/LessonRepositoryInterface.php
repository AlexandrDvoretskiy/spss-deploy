<?php

namespace App\Domain\Repository;

use App\Domain\Entity\Lesson;
use App\Domain\Model\ListItemLessonModel;

interface LessonRepositoryInterface
{
    public function create(Lesson $lesson): int;

    /**
     * @return ListItemLessonModel
     */
    public function getList(int $page, int $perPage): array;
}