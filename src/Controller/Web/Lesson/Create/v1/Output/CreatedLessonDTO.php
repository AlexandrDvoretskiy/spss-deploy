<?php

namespace App\Controller\Web\Lesson\Create\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

class CreatedLessonDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly PersistentCollection $tasks,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}