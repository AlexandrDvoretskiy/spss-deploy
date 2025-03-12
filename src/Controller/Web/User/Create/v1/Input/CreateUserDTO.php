<?php

namespace App\Controller\Web\User\Create\v1\Input;

use Symfony\Component\Validator\Constraints as Assert;

//#[Assert\Expression(
//    expression: '(this.email === null and this.phone !== null) or (this.phone === null and this.email !== null)',
//    message: 'Eiteher email or phone should be provided',
//)]
class CreateUserDTO
{
    public function __construct(
        #[Assert\NotBlank]
        #[Assert\Length(min: 5)]
        public readonly string $login,
    ) {
    }
}