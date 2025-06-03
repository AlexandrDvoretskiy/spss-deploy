<?php

namespace App\Controller\Web\Skill\Batch\v1\Input;

class BatchDTO
{
    public function __construct(
        public readonly string $skillPrefix,
        public readonly int $count,
        public readonly bool $async = false,
    ) {
    }
}