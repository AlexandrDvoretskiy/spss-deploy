<?php

namespace App\Controller\Amqp\AddSkills;

use App\Application\RabbitMq\AbstractConsumer;
use App\Controller\Amqp\AddSkills\Input\Message;
use App\Domain\Service\SkillService;
use App\Infrastructure\Storage\MetricsStorage;

class Consumer extends AbstractConsumer
{
    public function __construct(
        private readonly SkillService $skillService,
        public readonly MetricsStorage $metricsStorage,
        private readonly string $key,
    ) {
    }

    protected function getMessageClass(): string
    {
        return Message::class;
    }

    protected function handle($message): int
    {
        $this->skillService->batchSync($message->skillPrefix, $message->count);

        $this->metricsStorage->increment($this->key);

        return self::MSG_ACK;
    }
}