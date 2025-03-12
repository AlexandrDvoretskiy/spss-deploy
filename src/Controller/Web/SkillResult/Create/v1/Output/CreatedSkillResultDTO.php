<?php

namespace App\Controller\Web\SkillResult\Create\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use Doctrine\Common\Collections\Collection;

class CreatedSkillResultDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly array $user,
        public readonly array $skillRange,
        public readonly float $result,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}