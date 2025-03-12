<?php

namespace App\Controller\Web\Mark\Delete\v1;

use App\Domain\Entity\Mark;
use App\Domain\Service\MarkService;

class Manager
{
    public function __construct(
        private readonly MarkService $taskService
    )
    {
    }

    public function deleteMarkIfExists(int $id): bool
    {
        return $this->taskService->deleteMarkIfExists($id);
    }

}