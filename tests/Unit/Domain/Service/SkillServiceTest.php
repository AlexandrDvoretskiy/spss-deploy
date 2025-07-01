<?php

namespace Tests\Unit\Domain\Service;

use App\Domain\Bus\SkillBatchBusInterface;
use App\Domain\Entity\Skill;
use App\Domain\Model\CreateSkillModel;
use App\Domain\Service\SkillService;
use App\Domain\Service\TaskService;
use App\Infrastructure\Repository\SkillRepository;
use Generator;
use Codeception\Attribute\DataProvider;
use Mockery;
use Codeception\Test\Unit;

class SkillServiceTest extends Unit
{

    #[DataProvider('createTestCases')]
    public function testCreate(CreateSkillModel $createSkillModel, array $expectedData): void
    {
        $skillService = $this->prepareSkillService();

        $skill = $skillService->create($createSkillModel);

        $actualData = [
            $skill->getTitle()
        ];

        self::assertSame($expectedData, $actualData);
    }

    private function prepareSkillService(): SkillService
    {
        $skillRepository = Mockery::mock(SkillRepository::class)->shouldIgnoreMissing();
        $taskService = Mockery::mock(TaskService::class)->shouldIgnoreMissing();
        $skillBatchBusInterface = Mockery::mock(SkillBatchBusInterface::class);

        return new SkillService($skillRepository, $taskService, $skillBatchBusInterface);
    }

    public static function createTestCases(): array
    {
        return [
            "Positive - strings" => [
                new CreateSkillModel(
                    "Skill title",
                ),
                ["Skill title"],
            ],
            "Positive - numbers as a string" => [
                new CreateSkillModel(
                    "123456789",
                ),
                ["123456789"],
            ]
        ];
    }
}
