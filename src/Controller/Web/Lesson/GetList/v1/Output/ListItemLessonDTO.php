<?php

namespace App\Controller\Web\Lesson\GetList\v1\Output;

class ListItemLessonDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $createdAt,
    ) {

    }
}