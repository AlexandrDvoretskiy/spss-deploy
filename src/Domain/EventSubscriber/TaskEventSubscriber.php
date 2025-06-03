<?php

namespace App\Domain\EventSubscriber;

use App\Domain\Event\TaskIsCreatedEvent;
use App\Domain\Event\TaskIsDeletedEvent;
use App\Infrastructure\Storage\MetricsStorage;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class TaskEventSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly LoggerInterface $elasticsearchLogger,
        private readonly MetricsStorage $metricsStorage,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            TaskIsCreatedEvent::class => 'onTaskIsCreated',
            TaskIsDeletedEvent::class => 'onTaskIsDeleted',
        ];
    }

    public function onTaskIsCreated(TaskIsCreatedEvent $event): void
    {
        $this->elasticsearchLogger->info("Task is created: id {$event->id}, title {$event->title}");

        $this->metricsStorage->increment(MetricsStorage::TASK_CREATED);
    }

    public function onTaskIsDeleted(TaskIsDeletedEvent $event): void
    {
        $this->elasticsearchLogger->info("Task is deleted: id {$event->id}");
        $this->metricsStorage->increment(MetricsStorage::TASK_DELETED);
    }
}
