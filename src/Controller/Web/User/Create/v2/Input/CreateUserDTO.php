<?php

namespace App\Controller\Web\User\Create\v2\Input;

use Symfony\Component\Validator\Constraints as Assert;

class CreateUserDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 5)]
        public readonly string $login,
        #[Assert\NotBlank]
        public readonly string $password,
        /** @var string[] $roles */
        public readonly array $roles,
    ) {
    }
}