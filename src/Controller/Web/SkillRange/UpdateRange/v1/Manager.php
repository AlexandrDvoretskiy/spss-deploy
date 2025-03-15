<?php

namespace App\Controller\Web\SkillRange\UpdateRange\v1;

use App\Domain\Entity\SkillRange;
use App\Domain\Service\SkillRangeService;

class Manager
{
    public function __construct(
        private readonly SkillRangeService $skillRangeService
    )
    {
    }

    public function updateSkillRange(int $id, int $skillRange): array
    {
        return $this->skillRangeService->updateSkillRange($id, $skillRange);
    }

}