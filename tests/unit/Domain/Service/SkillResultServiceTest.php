<?php

namespace UnitTests\Domain\Service;

use App\Domain\DTO\SkillRangeByMark;
use App\Domain\DTO\SkillResultByMarkDTO;
use App\Domain\Entity\Lesson;
use App\Domain\Entity\Skill;
use App\Domain\Entity\SkillRange;
use App\Domain\Entity\Task;
use App\Domain\Entity\User;
use App\Domain\Service\SkillRangeService;
use App\Domain\Service\SkillResultService;
use App\Domain\Service\UserService;
use App\Infrastructure\Repository\SkillResultRepository;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionClass;

/**
 * Возможно, я запутался в понимании значения Юнит тестов
 * Тут правильная реализация или нет?
 *
 * В константы вынес все данные, которые понадобятся для создания / заполнения объектов для моков
 * Но, не совсеми понимаю, как добавить новые кейсы в addByMarkTestCases() ?
 *
 * Ведь объекты созданы с одними значениями, и ожидаемый результат сделан на основе этих данных.
 * В этом случае тест будет пройден
 *
 * Если указать что-то другое в addByMarkTestCases(), то тест не пройдет, нужно также изменить значения в константах
 *
 * Тут я запутался и не могу понять, как нужно писать тесты
 */
#[CoversClass(SkillResultService::class)]
class SkillResultServiceTest extends TestCase
{
    private const MARK = [
        "ID" => 1,
        "VALUE" => 8
    ];

    public const SKILL_RANGES = [
        [
            "ID" => 1,
            "SKILL_ID" => 1,
            "RANGE" => 20,
            "TITLE" => "Skill 1"
        ],
        [
            "ID" => 2,
            "SKILL_ID" => 2,
            "RANGE" => 30,
            "TITLE" => "Skill 2"
        ],
        [
            "ID" => 3,
            "SKILL_ID" => 3,
            "RANGE" => 40,
            "TITLE" => "Skill 3"
        ],
    ];

    private const USER = [
        "ID" => 18,
        "LOGIN" => "New test user",
        "ROLES" => [
            "DEFAULT" => "ROLE_USER",
            "VIEW" => "ROLE_VIEW",
            "EDIT" => "ROLE_EDIT",
        ]
    ];

    private const TASK = [
        "ID" => 73,
        "TITLE" => "Cache Task 1",
    ];

    private const LESSON = [
        "ID" => 2,
        "TITLE" => "Lesson N2"
    ];

    #[Test]
    #[DataProvider("addByMarkTestCases")]
    public function addByMark(SkillResultByMarkDTO $skillResultByMarkDTO, array $expectedData): void
    {
        $skillResultService = $this->prepareSkillResultService();

        $skillResult = $skillResultService->addByMark($skillResultByMarkDTO);

        $this::assertEqualsCanonicalizing($expectedData, $skillResult);
    }


    public static function addByMarkTestCases(): Generator
    {
        yield [
            new SkillResultByMarkDTO(
                self::USER["ID"],
                self::TASK["ID"],
                self::MARK["VALUE"],
            ),
            [
                [
                    "SKILL_RANGE" => [
                        "ID" => 1,
                        "RANGE" => 20,
                    ],
                    "RESULT" => [
                        "VALUE" => 1.6,
                    ],
                    "MARK" => [
                        "VALUE" => 8,
                    ],
                ],
                [
                    "SKILL_RANGE" => [
                        "ID" => 2,
                        "RANGE" => 30,
                    ],
                    "RESULT" => [
                        "VALUE" => 2.4,
                    ],
                    "MARK" => [
                        "VALUE" => 8,
                    ],
                ],
                [
                    "SKILL_RANGE" => [
                        "ID" => 3,
                        "RANGE" => 40,
                    ],
                    "RESULT" => [
                        "VALUE" => 3.2,
                    ],
                    "MARK" => [
                        "VALUE" => 8,
                    ],
                ],
            ]
        ];
    }

    private function prepareSkillResultService(): SkillResultService
    {
        $skillRangeService = $this->createMock(SkillRangeService::class);
        $skillRangeService->expects($this->once())
            ->method("findByTaskId")
            ->willReturnCallback(function () {
                return [
                    new SkillRangeByMark(
                        self::SKILL_RANGES[0]["ID"],
                        self::SKILL_RANGES[0]["SKILL_ID"],
                        self::SKILL_RANGES[0]["RANGE"]
                    ),
                    new SkillRangeByMark(
                        self::SKILL_RANGES[1]["ID"],
                        self::SKILL_RANGES[1]["SKILL_ID"],
                        self::SKILL_RANGES[1]["RANGE"]
                    ),
                    new SkillRangeByMark(
                        self::SKILL_RANGES[2]["ID"],
                        self::SKILL_RANGES[2]["SKILL_ID"],
                        self::SKILL_RANGES[2]["RANGE"]
                    ),
                ];
            });

        $userService = $this->createMock(UserService::class);
        $userService->expects($this->exactly(count(self::SKILL_RANGES)))
            ->method("findUserById")
            ->willReturnCallback(function (int $id) {
                $user = new User(
                    self::USER["LOGIN"],
                    [self::USER["ROLES"]["DEFAULT"]],
                );

                $reflection = (new \ReflectionClass(User::class));
                $reflectionProperty = $reflection->getProperty("id");
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($user, $id);

                return $user;
            });

        $skillRangeService->expects($this->exactly(count(self::SKILL_RANGES)))
            ->method("findById")
            ->willReturnCallback(function (int $id) {

                $skill = new Skill(self::SKILL_RANGES[($id-1)]["TITLE"]);
                $lesson = new Lesson(self::LESSON["TITLE"]);
                $task = new Task(self::TASK["TITLE"], $lesson);

                $skillRange = new SkillRange(
                    $skill,
                    $task,
                    self::SKILL_RANGES[($id-1)]["RANGE"]
                );

                return $skillRange;
            });

        $skillResultRepository = $this->createMock(SkillResultRepository::class);
        $skillResultRepository->expects($this->exactly(count(self::SKILL_RANGES)))
            ->method("create")
            ->willReturnCallback(function ($skillResult) {
                $reflection = new ReflectionClass($skillResult);
                $reflectionProperty = $reflection->getProperty("id");
                $reflectionProperty->setAccessible(true);
                $reflectionProperty->setValue($skillResult, 1);

                return 1;
            });

        return new SkillResultService($skillResultRepository, $userService, $skillRangeService);
    }
}
