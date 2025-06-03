<?php

namespace App\Controller\Web\Lesson\Create\v1;

use App\Controller\Web\Lesson\Create\v1\Input\CreateLessonDTO;
use App\Controller\Web\Lesson\Create\v1\Output\CreatedLessonDTO;
use Psr\Log\LoggerInterface;

class ManagerLoggerDecorator implements ManagerInterface
{
    public function __construct(
        private readonly ManagerInterface $manager,
        private readonly LoggerInterface $logger,
    ) {
    }

    public function create(CreateLessonDTO $createLessonDTO): CreatedLessonDTO
    {
        $this->addLogs();

        return $this->manager->create($createLessonDTO);
    }

    private function addLogs(): void
    {
        $this->logger->debug('This is CreateLesson debug message');
        $this->logger->info('This is CreateLesson info message');
        $this->logger->notice('This is CreateLesson notice message');
        $this->logger->warning('This is CreateLesson warning message');
        $this->logger->error('This is CreateLesson error message');
        $this->logger->critical('This is CreateLesson critical message');
        $this->logger->alert('This is CreateLesson alert message');
        $this->logger->emergency('This is CreateLesson emergency message');
    }
}