<?php

namespace App\Controller\Web\SkillResult\Delete\v1;

use App\Domain\Entity\SkillResult;
use App\Domain\Service\SkillResultService;

class Manager
{
    public function __construct(
        private readonly SkillResultService $skillResultService
    )
    {
    }

    public function deleteSkillResultIfExists(int $id): bool
    {
        return $this->skillResultService->deleteSkillResultIfExists($id);
    }

}