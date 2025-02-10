<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Skill;
use Doctrine\ORM\AbstractQuery;

/**
 * @extends AbstractRepository<Skill>
 */
class SkillRepository extends AbstractRepository
{
    public function create(Skill $skill): int
    {
        return $this->store($skill);
    }
}