<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\SkillResult;
use Doctrine\ORM\AbstractQuery;

/**
 * @extends AbstractRepository<SkillResult>
 */
class SkillResultRepository extends AbstractRepository
{
    public function create(SkillResult $skillResult): int
    {
        return $this->store($skillResult);
    }
}