<?php

namespace App\Controller\Web\User\Create\v2\Output;

use App\Controller\DTO\OutputDTOInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

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