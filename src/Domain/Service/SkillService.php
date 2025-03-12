<?php

namespace App\Domain\Service;

use App\Domain\Entity\Skill;
use App\Domain\Model\CreateSkillModel;
use App\Infrastructure\Repository\SkillRepository;

class SkillService
{
    public function __construct(
        private readonly SkillRepository $skillRepository,
        private readonly TaskService $taskService,
    )
    {
    }

    public function create(CreateSkillModel $createSkillModel): Skill
    {
        $skill = new Skill(
            $createSkillModel->title
        );

        $this->skillRepository->create($skill);

        return $skill;
    }

    public function findById(int $id): ?Skill
    {
        return $this->skillRepository->find($id);
    }

    public function deleteSkillIfExists(int $id): bool
    {
        return $this->skillRepository->deleteSkillIfExists($id);
    }
}