<?php

namespace App\Controller\Web\SkillResult\Create\v1;

use App\Controller\Web\SkillResult\Create\v1\Input\CreateSkillResultDTO;
use App\Controller\Web\SkillResult\Create\v1\Output\CreatedSkillResultDTO;
use App\Domain\Model\CreateSkillResultModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\SkillResultService;

class Manager
{
    public function __construct(
        private readonly ModelFactory $modelFactory,
        private readonly SkillResultService $skillResultService
    )
    {
    }

    public function create(CreateSkillResultDTO $createSkillResultDTO): CreatedSkillResultDTO
    {
        $createSkillResultModel = $this->modelFactory->makeModel(
            CreateSkillResultModel::class,
            $createSkillResultDTO->user,
            $createSkillResultDTO->skillRange,
            $createSkillResultDTO->result
        );
        $skillResult = $this->skillResultService->create($createSkillResultModel);

        return new CreatedSkillResultDTO(
            $skillResult->getId(),
            $skillResult->getUser(),
            $skillResult->getSkillRange(),
            $skillResult->getResult(),
            $skillResult->getCreatedAt()->format("d.m.Y H:i:s"),
            $skillResult->getUpdatedAt()->format("d.m.Y H:i:s"),
        );
    }
}