<?php

namespace App\Domain\Event;

class TaskIsDeletedEvent
{
    public function __construct(
        public readonly int $id
    ) {
    }
}