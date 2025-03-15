<?php

namespace App\Controller\Web\Mark\Create\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

class CreateMarkDTO
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