<?php

namespace App\Controller\Web\SkillRange\Get\v1;

use App\Domain\Entity\SkillRange;
use App\Domain\Service\SkillRangeService;

class Manager
{
    public function __construct(
        private readonly SkillRangeService $skillRangeService
    )
    {
    }

    public function findById(int $id): SkillRange
    {
        return $this->skillRangeService->findById($id);
    }
}