<?php

namespace App\Controller\Web\SkillRange\Create\v1;

use App\Controller\Web\SkillRange\Create\v1\Input\CreateSkillRangeDTO;
use App\Controller\Web\SkillRange\Create\v1\Output\CreatedSkillRangeDTO;
use App\Domain\Model\CreateSkillRangeModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\SkillRangeService;

class Manager
{
    public function __construct(
        private readonly ModelFactory $modelFactory,
        private readonly SkillRangeService $skillRangeService
    )
    {
    }

    public function create(CreateSkillRangeDTO $createSkillRangeDTO): CreatedSkillRangeDTO
    {
        $createSkillRangeModel = $this->modelFactory->makeModel(
            CreateSkillRangeModel::class,
            $createSkillRangeDTO->skill,
            $createSkillRangeDTO->task,
            $createSkillRangeDTO->range
        );
        $skillRange = $this->skillRangeService->create($createSkillRangeModel);

        return new CreatedSkillRangeDTO(
            $skillRange->getId(),
            $skillRange->getSkill(),
            $skillRange->getTask(),
            $skillRange->getRange(),
            $skillRange->getCreatedAt()->format("d.m.Y H:i:s"),
            $skillRange->getUpdatedAt()->format("d.m.Y H:i:s"),
        );
    }
}