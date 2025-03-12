<?php

namespace App\Controller\Web\Mark\Create\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use Doctrine\Common\Collections\Collection;

class CreatedMarkDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly int $mark,
        public readonly array $user,
        public readonly array $task,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}