<?php

namespace App\Domain\Model;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserModel
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 5)]
        public readonly string $login,
    ) {
    }
}