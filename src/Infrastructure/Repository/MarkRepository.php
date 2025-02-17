<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Mark;
use Doctrine\ORM\AbstractQuery;

/**
 * @extends AbstractRepository<Mark>
 */
class MarkRepository extends AbstractRepository
{
    public function create(Mark $mark): int
    {
        return $this->store($mark);
    }
}