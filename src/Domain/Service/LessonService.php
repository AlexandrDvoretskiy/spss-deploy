<?php

namespace App\Domain\Service;

use App\Controller\Web\Lesson\GetList\v1\Output\ListItemLessonDTO;
use App\Domain\Entity\Lesson;
use App\Domain\Entity\User;
use App\Domain\Model\CreateLessonModel;
use App\Domain\Model\ListItemLessonModel;
use App\Domain\Repository\LessonRepositoryInterface;
use App\Infrastructure\Repository\LessonRepository;

class LessonService
{
    public function __construct(
        private readonly LessonRepository $lessonRepository,
        private readonly LessonRepositoryInterface $domainRepository,
    ) {
    }

    public function create(CreateLessonModel $createLessonModel): Lesson
    {
        $lesson = new Lesson(
            $createLessonModel->title
        );
        $this->domainRepository->create($lesson);

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

    public function getList(int $page, int $perPage): array
    {
         return $this->domainRepository->getList($page, $perPage);
    }
}