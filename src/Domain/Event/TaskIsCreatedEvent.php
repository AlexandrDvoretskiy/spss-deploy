<?php

namespace App\Domain\Event;

class TaskIsCreatedEvent
{
    public function __construct(
        public readonly int $id,
        public readonly string $title,
    ) {
    }
}