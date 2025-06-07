<?php

namespace App\Domain\DTO;

class SkillRangeByMark
{
    public function __construct(
        public readonly int $id,
        public readonly int $skillId,
        public readonly int $range
    ) {
    }
}