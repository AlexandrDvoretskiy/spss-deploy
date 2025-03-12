<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CreateSkillRangeModel
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\Positive]
        public readonly int $skill,

        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\Positive]
        public readonly int $task,

        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\Positive]
        #[Assert\Range(
            min: 1,
            max: 100
        )]
        public readonly int $range,
    ) {
    }
}