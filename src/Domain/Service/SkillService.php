<?php

namespace App\Domain\Service;

use App\Domain\Bus\SkillBatchBusInterface;
use App\Domain\DTO\SkillBatchDTO;
use App\Domain\Entity\Skill;
use App\Domain\Model\CreateSkillModel;
use App\Infrastructure\Repository\SkillRepository;

class SkillService
{
    public function __construct(
        private readonly SkillRepository $skillRepository,
        private readonly TaskService $taskService,
        private readonly SkillBatchBusInterface $skillBatchBus,
    )
    {
    }

    public function create(CreateSkillModel $createSkillModel): Skill
    {
        if (empty($createSkillModel->title)) {
            throw new \InvalidArgumentException("Title cannot be empty");
        }

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

    public function batchSync(string $skillPrefix, int $count): int
    {
        $createdSkills = 0;

        for ($i = 0; $i < $count; $i++) {
            $title = "{$skillPrefix} Skill {$i}";
            $model = new CreateSkillModel($title);
            $this->create($model);

            $createdSkills++;
        }

        return $createdSkills;
    }

    public function batchAsync(SkillBatchDTO $batchDTO): int
    {
        return $this->skillBatchBus->skillBatchMessage($batchDTO) ? $batchDTO->count : 0;
    }
}