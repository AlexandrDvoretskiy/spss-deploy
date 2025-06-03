<?php

namespace App\Controller\Web\Lesson\Create\v1;

use App\Controller\Web\Lesson\Create\v1\Input\CreateLessonDTO;
use App\Controller\Web\Lesson\Create\v1\Output\CreatedLessonDTO;
use App\Domain\Model\CreateLessonModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\LessonService;

class Manager implements ManagerInterface
{
    public function __construct(
        /** @var ModelFactory<CreateLessonModel> */
        private readonly ModelFactory $modelFactory,
        private readonly LessonService $lessonService,
    ) {
    }

    public function create(CreateLessonDTO $createLessonDTO): CreatedLessonDTO
    {
        $createLessonModel = $this->modelFactory->makeModel(CreateLessonModel::class, $createLessonDTO->title);
        $lesson = $this->lessonService->create($createLessonModel);

        return new CreatedLessonDTO(
            $lesson->getId(),
            $lesson->getTitle(),
            $lesson->getTasks(),
            $lesson->getCreatedAt()->format('Y-m-d H:i:s'),
            $lesson->getUpdatedAt()->format('Y-m-d H:i:s'),
        );
    }
}