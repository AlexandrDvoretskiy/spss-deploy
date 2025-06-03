<?php

namespace App\Controller\Amqp\AddSkills\Input;

use Symfony\Component\Validator\Constraints as Assert;

class Message
{
    public function __construct(
        #[Assert\Type('string')]
        #[Assert\Length(max: 32)]
        public readonly string $skillPrefix,
        #[Assert\Type('numeric')]
        public readonly int $count,
    ) {
    }
}