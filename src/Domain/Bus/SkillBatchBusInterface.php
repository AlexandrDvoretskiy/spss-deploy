<?php

namespace App\Domain\Bus;

use App\Domain\DTO\SkillBatchDTO;

interface SkillBatchBusInterface
{
    public function skillBatchMessage(SkillBatchDTO $skillBatchDTO);
}