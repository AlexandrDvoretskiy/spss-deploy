<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CreateMarkModel
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\Positive]
        public readonly int $mark,

        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\Positive]
        public readonly int $user,

        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\Positive]
        public readonly int $task,
    ) {
    }
}