<?php

namespace App\Controller\Web\SkillRange\Create\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use Doctrine\Common\Collections\Collection;

class CreatedSkillRangeDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly array $skill,
        public readonly array $task,
        public readonly int $range,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}