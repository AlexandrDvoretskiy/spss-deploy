<?php

namespace FunctionalTests\Service;

use App\Domain\Entity\Lesson;
use App\Domain\Entity\Task;
use App\Domain\Model\CreateTaskModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\TaskService;
use App\Tests\Support\FunctionalTester;
use Codeception\Attribute\DataProvider;
use Codeception\Example;

class TaskServiceCest
{

    public function _before(FunctionalTester $I): void
    {
        $I->haveInRepository(Lesson::class, [
            'title' => 'FunctionalLesson1'
        ]);
        $lesson = $I->grabEntityFromRepository(Lesson::class, ['title' => 'FunctionalLesson1']);

        $I->haveInRepository(Task::class, [
            'title' => 'FunctionalTask1',
            'lesson' => $lesson
        ]);
    }

    public function testFindById(FunctionalTester $I, Example $example): void
    {
        $lesson = $I->grabEntityFromRepository(Lesson::class, ['title' => 'FunctionalLesson1']);
        $task = $I->grabEntityFromRepository(Task::class, ['title' => 'FunctionalTask1']);

        dd($lesson);
    }


    protected function createTaskDataProvider(): array
    {
        return [
            'all' => [
                'validData' => ['Тестовая задача', 1]
            ],
        ];
    }
}
