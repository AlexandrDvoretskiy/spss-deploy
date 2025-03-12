<?php

namespace App\Controller\Web\User\Create\v1\Output;

use App\Controller\DTO\OutputDTOInterface;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\PersistentCollection;

class CreatedUserDTO implements OutputDTOInterface
{
    public function __construct(
        public readonly int $id,
        public readonly string $login,
        public readonly PersistentCollection $marks,
        public readonly PersistentCollection $skillResults,
        public readonly string $createdAt,
        public readonly string $updatedAt,
    ) {
    }
}