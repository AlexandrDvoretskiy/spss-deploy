<?php

namespace App\Controller\Web\Mark\Get\v1;

use App\Domain\Entity\Mark;
use App\Domain\Service\MarkService;

class Manager
{
    public function __construct(
        private readonly MarkService $markService
    )
    {
    }

    public function findById(int $id): Mark
    {
        return $this->markService->findById($id);
    }
}