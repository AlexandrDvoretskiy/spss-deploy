<?php

namespace App\Controller\Web\Lesson\Delete\v1;

use App\Domain\Model\CreateUserModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\LessonService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateUserModel> */
        private readonly ModelFactory $modelFactory,
        private readonly LessonService $lessonService,
    ) {
    }

    public function deleteLessonIfExists(int $id): bool
    {
        return $this->lessonService->deleteLessonIfExists($id);
    }
}