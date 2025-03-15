<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CreateLessonModel
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 5)]
        public readonly string $title,
    ) {
    }
}