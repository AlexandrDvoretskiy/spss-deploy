<?php

namespace App\Domain\EventSubscriber;

use App\Domain\Event\MarkIsCreatedEvent;

use App\Domain\Storage\MetricsStorageInterface;
use Psr\Log\LoggerInterface;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class MarkEventSubscriber implements EventSubscriberInterface
{

    public function __construct(
        public readonly LoggerInterface $elasticsearchLogger,
        private readonly MetricsStorageInterface $metricsStorage,
    ){

    }

    public static function getSubscribedEvents(): array
    {
        return [
            MarkIsCreatedEvent::class => 'onMarkIsCreated',
        ];
    }

    public function onMarkIsCreated(MarkIsCreatedEvent $event): void
    {
        $this->elasticsearchLogger->info("Mark is created: \n user: {$event->userId}, task: {$event->taskId}, mark: {$event->mark}");

        if ($code = $this->metricsStorage->getCode("MARK_CREATED")) {
            $this->metricsStorage->increment($code);
        }
    }

}