<?php

namespace App\Domain\Event;

class MarkIsCreatedEvent
{
    public function __construct(
        public readonly int $userId,
        public readonly int $taskId,
        public readonly int $mark,
    ){
    }
}