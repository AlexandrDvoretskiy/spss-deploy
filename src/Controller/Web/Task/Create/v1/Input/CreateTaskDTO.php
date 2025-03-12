<?php

namespace App\Controller\Web\Task\Create\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

class CreateTaskDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 5)]
        public readonly string $title,

        #[Assert\NotBlank]
        #[Assert\Type(
            type: 'integer',
            message: 'The value {{ value }} is not a valid {{ type }} (dto)',
        )]
        #[Assert\Positive]
        public readonly int $lesson,
    ) {
    }
}