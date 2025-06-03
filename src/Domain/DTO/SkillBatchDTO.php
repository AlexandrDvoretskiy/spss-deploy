<?php

namespace App\Domain\DTO;

class SkillBatchDTO
{
    public function __construct(
        public readonly string $skillPrefix,
        public readonly int $count,
    ) {
    }
}