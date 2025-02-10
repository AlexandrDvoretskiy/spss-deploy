<?php

namespace App\Domain\Service;

use App\Domain\Entity\SkillRange;
use App\Infrastructure\Repository\SkillRangeRepository;

class SkillRangeService
{
    public function __construct(private readonly SkillRangeRepository $skillRangeRepository)
    {
    }

    public function create(): SkillRange
    {

    }
}