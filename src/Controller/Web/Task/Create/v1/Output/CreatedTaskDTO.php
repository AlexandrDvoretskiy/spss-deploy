<?php

namespace App\Controller\Web\Task\Create\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use Doctrine\Common\Collections\Collection;

class CreatedTaskDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
        public readonly array $lesson,
        public readonly array $skills,
        public readonly array $marks,
        public readonly array $ranges,
        public readonly array $skillResults,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}