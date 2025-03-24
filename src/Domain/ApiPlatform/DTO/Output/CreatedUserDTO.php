<?php

namespace App\Domain\ApiPlatform\DTO\Output;

use App\Controller\DTO\OutputDTOInterface;

class CreatedUserDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $login,
        /** @var string[] $roles */
        public readonly array $roles,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}