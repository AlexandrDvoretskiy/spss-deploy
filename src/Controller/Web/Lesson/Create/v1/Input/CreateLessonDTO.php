<?php

namespace App\Controller\Web\Lesson\Create\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

class CreateLessonDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 5)]
        public readonly string $title,
    ) {
    }
}