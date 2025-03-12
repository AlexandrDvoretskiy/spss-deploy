<?php

namespace App\Controller\Web\SkillRange\Delete\v1;

use App\Domain\Entity\SkillRange;
use App\Domain\Service\SkillRangeService;

class Manager
{
    public function __construct(
        private readonly SkillRangeService $skillRangeService
    )
    {
    }

    public function deleteSkillRangeIfExists(int $id): bool
    {
        return $this->skillRangeService->deleteSkillRangeIfExists($id);
    }

}