<?php

namespace App\Domain\Service;

use App\Domain\Entity\SkillResult;
use App\Infrastructure\Repository\SkillResultRepository;

class SkillResultService
{
    public function __construct(private readonly SkillResultRepository $skillResultRepository)
    {
    }

    public function create(): SkillResult
    {

    }
}