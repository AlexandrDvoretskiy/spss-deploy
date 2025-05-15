<?php

namespace App\Domain\Model;

class ListItemLessonModel
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly string $createdAt,
    ) {

    }
}