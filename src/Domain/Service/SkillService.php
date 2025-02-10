<?php

namespace App\Domain\Service;

use App\Domain\Entity\Skill;
use App\Infrastructure\Repository\SkillRepository;

class SkillService
{
    public function __construct(private readonly SkillRepository $skillRepository)
    {
    }

    public function create(): Skill
    {

    }
}