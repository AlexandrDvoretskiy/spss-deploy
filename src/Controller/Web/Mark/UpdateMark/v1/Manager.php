<?php

namespace App\Controller\Web\Mark\UpdateMark\v1;

use App\Domain\Entity\Mark;
use App\Domain\Service\MarkService;

class Manager
{
    public function __construct(
        private readonly MarkService $markService
    )
    {
    }

    public function updateMark(int $id, int $mark): array
    {
        return $this->markService->updateMark($id, $mark);
    }

}