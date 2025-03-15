<?php

namespace App\Controller\Web\Lesson\Get\v1;

use App\Domain\Entity\Lesson;
use App\Domain\Entity\User;
use App\Domain\Service\LessonService;

class Manager
{
    public function __construct(
        private readonly  LessonService $lessonService
    )
    {
    }

    public function findById(int $id): ?Lesson
    {
        return $this->lessonService->findById($id);
    }
}