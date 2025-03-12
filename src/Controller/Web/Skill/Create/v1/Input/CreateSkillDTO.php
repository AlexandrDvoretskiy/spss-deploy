<?php

namespace App\Controller\Web\Skill\Create\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

class CreateSkillDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 5)]
        public readonly string $title,
    ) {
    }
}