<?php

namespace App\Controller\Web\Skill\Batch\v1;

use App\Controller\Web\Skill\Batch\v1\Input\BatchDTO as ControllerBatchDTO;
use App\Domain\DTO\SkillBatchDTO as DomainBatchDTO;
use App\Domain\Service\SkillService;

class Manager
{
    public function __construct(
        public readonly SkillService $skillService,
    ) {
    }

    public function batch(ControllerBatchDTO $batchDTO): int
    {
        return $batchDTO->async ?
            $this->skillService->batchAsync(
                new DomainBatchDTO(
                    $batchDTO->skillPrefix,
                    $batchDTO->count
                )
            ) :
            $this->skillService->batchSync($batchDTO->skillPrefix, $batchDTO->count);
    }
}