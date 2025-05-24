<?php

namespace App\Infrastructure\Bus\Adapter;

use App\Domain\Bus\SkillBatchBusInterface;
use App\Domain\DTO\SkillBatchDTO;
use App\Infrastructure\Bus\AmqpExchangeEnum;
use App\Infrastructure\Bus\RabbitMqBus;

class SkillBatchRabbitMqBus implements SkillBatchBusInterface
{
    public function __construct(
        private readonly RabbitMqBus $rabbitMqBus,
    ) {
    }

    public function skillBatchMessage(SkillBatchDTO $skillBatchDTO): bool
    {
        return $this->rabbitMqBus->publishToExchange(AmqpExchangeEnum::AddSkills, $skillBatchDTO);
    }
}