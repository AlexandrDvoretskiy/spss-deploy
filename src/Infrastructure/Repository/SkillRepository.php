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

    public function find(int $id): ?Skill
    {
        return $this->entityManager->getRepository(Skill::class)->find($id);
    }

    public function deleteSkillIfExists(int $id): bool
    {
        $skill = $this->find($id);

        if ($skill instanceof Skill) {
            $this->remove($skill);
            $this->flush();

            return true;
        }

        return false;
    }
}