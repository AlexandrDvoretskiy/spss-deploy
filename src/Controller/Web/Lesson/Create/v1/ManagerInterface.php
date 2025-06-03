<?php

namespace App\Controller\Web\Lesson\Create\v1;

use App\Controller\Web\Lesson\Create\v1\Input\CreateLessonDTO;
use App\Controller\Web\Lesson\Create\v1\Output\CreatedLessonDTO;

interface ManagerInterface
{
    public function create(CreateLessonDTO $createLessonDTO): CreatedLessonDTO;
}