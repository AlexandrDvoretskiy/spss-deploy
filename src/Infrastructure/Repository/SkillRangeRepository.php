<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\SkillRange;
use Doctrine\ORM\AbstractQuery;

/**
 * @extends AbstractRepository<SkillRange>
 */
class SkillRangeRepository extends AbstractRepository
{
    public function create(SkillRange $skillRange): int
    {
        return $this->store($skillRange);
    }
}