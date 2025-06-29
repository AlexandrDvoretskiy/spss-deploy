<?php

namespace App\Domain\DTO;

class SkillResultByMarkDTO
{
    public function __construct(
        public readonly int $userId,
        public readonly int $taskId,
        public readonly int $mark,
    ) {
    }
}