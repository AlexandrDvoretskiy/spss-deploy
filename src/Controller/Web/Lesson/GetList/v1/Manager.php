<?php

namespace App\Controller\Web\Lesson\GetList\v1;

use App\Controller\Web\Lesson\GetList\v1\Output\ListItemLessonDTO;
use App\Domain\Model\ListItemLessonModel;
use App\Domain\Service\LessonService;

class Manager
{
    public function __construct(
        private readonly LessonService $lessonService,
    ) {
    }

    public function getList(int $page, int $perPage): array
    {
        return array_map(
            static fn (ListItemLessonModel $lesson) => new ListItemLessonDTO(
                $lesson->id,
                $lesson->title,
                $lesson->createdAt
            ),
            $this->lessonService->getList($page, $perPage)
        );
    }
}