<?php

namespace App\Domain\Service;

use App\Domain\DTO\SkillResultByMarkDTO;
use App\Domain\Entity\SkillResult;
use App\Domain\Model\CreateSkillResultModel;
use App\Infrastructure\Repository\SkillResultRepository;

class SkillResultService
{
    public function __construct(
        private readonly SkillResultRepository $skillResultRepository,
        private readonly UserService $userService,
        private readonly SkillRangeService $skillRangeService
    )
    {
    }

    public function create(CreateSkillResultModel $createSkillRangeModel): SkillResult
    {
        $skillResult = new SkillResult(
            $this->userService->findUserById($createSkillRangeModel->user),
            $this->skillRangeService->findById($createSkillRangeModel->skillRange),
            $createSkillRangeModel->result
        );

        $this->skillResultRepository->create($skillResult);

        return $skillResult;
    }

    public function findById(int $id): SkillResult
    {
        return $this->skillResultRepository->find($id);
    }

    public function deleteSkillResultIfExists(int $id): bool
    {
        return $this->skillResultRepository->deleteSkillResultIfExists($id);
    }

    public function addByMark(SkillResultByMarkDTO $skillResultByMarkDTO): void
    {
        $skillRanges = $this->skillRangeService->findByTaskId($skillResultByMarkDTO->taskId);

        if (count($skillRanges) > 0) {
            foreach ($skillRanges as $skillRange) {
                $result = $this->calculateResult($skillRange->range, $skillResultByMarkDTO->mark);

                $skillResult = new SkillResult(
                    $this->userService->findUserById($skillResultByMarkDTO->userId),
                    $this->skillRangeService->findById($skillRange->id),
                    $result,
                );

                $this->skillResultRepository->create($skillResult);
            }
        }
    }

    public function calculateResult(int $range, int $mark): int|float
    {
        return $mark * $range / 100;
    }
}