<?php

namespace App\Controller\Web\Skill\Create\v1;

use App\Domain\Entity\Skill;
use App\Controller\Web\Skill\Create\v1\Input\CreateSkillDTO;
use App\Controller\Web\Skill\Create\v1\Output\CreatedSkillDTO;
use App\Domain\Model\CreateSkillModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\SkillService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateSkillModel> */
        private readonly ModelFactory $modelFactory,
        private readonly SkillService $skillService,
    ) {
    }

    public function create(CreateSkillDTO $createSkillDTO): CreatedSkillDTO
    {
        $createSkillModel = $this->modelFactory->makeModel(CreateSkillModel::class, $createSkillDTO->title, $createSkillDTO->task);
        $skill = $this->skillService->create($createSkillModel);

        return new CreatedSkillDTO(
            $skill->getId(),
            $skill->getTitle(),
            $skill->getCreatedAt()->format('Y-m-d H:i:s'),
            $skill->getUpdatedAt()->format('Y-m-d H:i:s'),
        );
    }
}