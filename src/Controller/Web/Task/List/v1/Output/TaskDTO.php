<?php

namespace App\Controller\Web\Task\List\v1\Output;

class TaskDTO
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly array $lesson,
        public readonly string $createdAt
    ) {
    }
}