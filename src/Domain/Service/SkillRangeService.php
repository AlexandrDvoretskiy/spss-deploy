<?php

namespace App\Domain\Service;

use App\Domain\DTO\SkillRangeByMark;
use App\Domain\Entity\SkillRange;
use App\Domain\Model\CreateSkillRangeModel;
use App\Infrastructure\Repository\SkillRangeRepository;

class SkillRangeService
{
    public function __construct(
        private readonly SkillRangeRepository $skillRangeRepository,
        private readonly SkillService $skillService,
        private readonly TaskService $taskService,
    )
    {
    }

    public function create(CreateSkillRangeModel $createSkillRangeModel): SkillRange
    {
        $skillRange = new SkillRange(
            $this->skillService->findById($createSkillRangeModel->skill),
            $this->taskService->findById($createSkillRangeModel->task),
            $createSkillRangeModel->range
        );

        $this->skillRangeRepository->create($skillRange);

        return $skillRange;
    }

    public function findById(int $id): SkillRange
    {
        return $this->skillRangeRepository->find($id);
    }

    public function deleteSkillRangeIfExists(int $id): bool
    {
        return $this->skillRangeRepository->deleteSkillRangeIfExists($id);

    }

    public function updateSkillRange(int $id, int $skillRange): array
    {
        if ($this->skillRangeRepository->updateSkillRange($id, $skillRange)) {
            return $this->findById($id)->toArray();
        }

        return ["success" => false];
    }

    public function findByTaskId(int $taskId): array
    {
        return array_map(
            static fn(array $skillRange) => new SkillRangeByMark(
                $skillRange['id'],
                $skillRange["skill"],
                $skillRange["range"]
            ),
            $this->skillRangeRepository->findByTaskId($taskId)
        );
    }
}