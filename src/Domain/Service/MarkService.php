<?php

namespace App\Domain\Service;

use App\Domain\Entity\Mark;
use App\Infrastructure\Repository\MarkRepository;

class MarkService
{
    public function __construct(private readonly MarkRepository $markRepository)
    {
    }

    public function create(): Mark
    {

    }
}