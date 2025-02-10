<?php

namespace App\Domain\Service;

use App\Domain\Entity\Lesson;
use App\Infrastructure\Repository\LessonRepository;

class LessonService
{
    public function __construct(private readonly LessonRepository $lessonRepository)
    {
    }

    public function create(): Lesson
    {

    }
}