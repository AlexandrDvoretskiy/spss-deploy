<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CreateTaskModel
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 5)]
        public readonly string $title,

        #[Assert\NotBlank]
        #[Assert\Type(
            type: 'integer',
            message: 'The value {{ value }} is not a valid {{ type }} (model)',
        )]
        #[Assert\Positive]
        public readonly int $lesson,
    ) {
    }
}