<?php

namespace App\Controller\Web\Skill\Get\v1;

use App\Domain\Entity\Skill;
use App\Domain\Entity\User;
use App\Domain\Service\SkillService;

class Manager
{
    public function __construct(
        private readonly  SkillService $skillService
    )
    {
    }

    public function findById(int $id): ?Skill
    {
        return $this->skillService->findById($id);
    }
}