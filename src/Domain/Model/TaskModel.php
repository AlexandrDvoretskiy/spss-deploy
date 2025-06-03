<?php

namespace App\Domain\Model;

class TaskModel
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly array $lesson,
        public readonly string $createdAt,
    ) {
    }
}