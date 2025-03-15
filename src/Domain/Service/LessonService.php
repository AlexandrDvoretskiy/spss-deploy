<?php

namespace App\Domain\Service;

use App\Domain\Entity\Lesson;
use App\Domain\Entity\User;
use App\Domain\Model\CreateLessonModel;
use App\Infrastructure\Repository\LessonRepository;

class LessonService
{
    public function __construct(
        private readonly LessonRepository $lessonRepository
    )
    {
    }

    public function create(CreateLessonModel $createLessonModel): Lesson
    {
        $lesson = new Lesson(
            $createLessonModel->title
        );
        $this->lessonRepository->create($lesson);

        return $lesson;
    }

    public function findById(int $id): ?Lesson
    {
        return $this->lessonRepository->findById($id);
    }

    public function deleteLessonIfExists(int $id): bool
    {
        return $this->lessonRepository->deleteLessonIfExists($id);
    }
}