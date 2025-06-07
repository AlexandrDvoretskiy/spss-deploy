<?php

namespace UnitTests\Domain\Service;

use App\Domain\Entity\Lesson;
use App\Domain\Entity\Mark;
use App\Domain\Entity\Task;
use App\Domain\Entity\User;
use App\Domain\Model\CreateMarkModel;
use App\Domain\Model\CreateUserModel;
use App\Domain\Service\MarkService;
use App\Domain\Service\TaskService;
use App\Domain\Service\UserService;
use App\Infrastructure\Repository\MarkRepository;
use Generator;
use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Symfony\Component\EventDispatcher\EventDispatcherInterface;

#[CoversClass(MarkService::class)]
class MarkServiceTest extends TestCase
{
    private const MARK = [
        "ID" => 1,
        "VALUE" => 10
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

    /**
     * @param CreateMarkModel $createMarkModel
     * @param array $expectedData
     * @return void
     */
    #[Test]
    #[DataProvider("createTestCases")]
    public function create(CreateMarkModel $createMarkModel, array $expectedData): void
    {
        /**
         * Чего не хватает текущему тесту?
         */

        $markService = $this->prepareMarkService();

        $mark = $markService->create($createMarkModel);

        $actualMark = $this->unsetDateTime($mark->toArray());

        $this::assertInstanceOf(Mark::class, $mark);
        $this::assertIsArray($actualMark);
        $this::assertNotNull($actualMark);
        $this::assertEquals($expectedData, $actualMark);
        $this::assertSame($expectedData, $actualMark);
    }

    public function prepareMarkService(): MarkService
    {
        /**
         * Правильно ли описаны моки?
         */

        $markRepository = $this->createMock(MarkRepository::class);
        $markRepository->expects($this->once())
            ->method("create")
            ->willReturnCallback(function(Mark $mark) {
                $reflection = (new \ReflectionClass(Mark::class));
                $idProperty = $reflection->getProperty("id");
                $idProperty->setAccessible(true);
                $idProperty->setValue($mark, self::MARK["ID"]);

                return self::MARK["ID"];
            });

        $userService = $this->createMock(UserService::class);
        $userService->expects($this->once())
            ->method("findUserById")
            ->willReturnCallback(function (int $id) {
                $user = new User(
                    self::USER["LOGIN"],
                    [self::USER["ROLES"]["DEFAULT"]]
                );

                $reflection = (new \ReflectionClass(User::class));
                $idProperty = $reflection->getProperty("id");
                $idProperty->setAccessible(true);
                $idProperty->setValue($user, $id);

                return $user;
            });

        $taskService = $this->createMock(TaskService::class);
        $taskService->expects($this->once())
            ->method("findById")
            ->willReturnCallback(function (int $id) {
                $lesson = new Lesson(
                    self::LESSON["TITLE"]
                );

                $reflection = (new \ReflectionClass(Lesson::class));
                $idProperty = $reflection->getProperty("id");
                $idProperty->setAccessible(true);
                $idProperty->setValue($lesson, self::LESSON["ID"]);

                $task = new Task(
                    self::TASK["TITLE"],
                    $lesson,
                );

                $reflection = (new \ReflectionClass(Task::class));
                $idProperty = $reflection->getProperty("id");
                $idProperty->setAccessible(true);
                $idProperty->setValue($task, $id);

                return $task;
            });

        /**
         * Как убедиться, что диспатчер действительно отработан тестом?
         * expects(once()) - этого достаточно?
         * Т.к. в диспатчере содерждится вызов другой логики (Проверяю ее в SkillResultServiceTest)
         */

        $eventDispatcher = $this->createMock(EventDispatcherInterface::class);
        $eventDispatcher->expects($this->once())
            ->method("dispatch");

        return new MarkService($markRepository, $userService, $taskService, $eventDispatcher);
    }

    public static function createTestCases(): Generator
    {
        /**
         * Не понимаю, как указать негативный сценарий
         */

        yield [
            new CreateMarkModel(
                self::MARK["VALUE"],
                self::USER["ID"],
                self::TASK["ID"],
            ),
            [
                "id" => self::MARK["ID"],
                "mark" => self::MARK["VALUE"],
                "user" => [
                    "id" => self::USER["ID"],
                    "login" => self::USER["LOGIN"],
                ],
                "task" => [
                    "id" => self::TASK["ID"],
                    "title" => self::TASK["TITLE"],
                    "lesson" => [
                        "id" => self::LESSON["ID"],
                        "title" => self::LESSON["TITLE"]
                    ],
                ],
            ]
        ];
    }

    public function unsetDateTime(array $data): array
    {
        $removeKeys = function (array &$array) use (&$removeKeys) {
            foreach ($array as $key => &$value) {
                if (is_array($value)) {
                    $removeKeys($value);
                }
                if ($key === 'createdAt' || $key === 'updatedAt') {
                    unset($array[$key]);
                }
            }
        };

        $removeKeys($data);

        return $data;
    }
}
