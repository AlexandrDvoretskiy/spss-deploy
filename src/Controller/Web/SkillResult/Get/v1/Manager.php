<?php

namespace App\Controller\Web\SkillResult\Get\v1;

use App\Domain\Entity\SkillResult;
use App\Domain\Service\SkillResultService;

class Manager
{
    public function __construct(
        private readonly SkillResultService $skillResultService
    )
    {
    }

    public function findById(int $id): SkillResult
    {
        return $this->skillResultService->findById($id);
    }
}