<?php

namespace App\Controller\Web\SkillResult\Create\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

class CreateSkillResultDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\Positive]
        public readonly int $user,

        #[Assert\NotBlank]
        #[Assert\Type('integer')]
        #[Assert\Positive]
        public readonly int $skillRange,

        #[Assert\NotBlank]
        #[Assert\Type('float')]
        #[Assert\Positive]
        public readonly float $result,
    ) {
    }
}