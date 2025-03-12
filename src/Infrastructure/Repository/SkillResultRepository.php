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

    public function find(int $id): SkillResult
    {
        return $this->entityManager->getRepository(SkillResult::class)->find($id);
    }

    public function deleteSkillResultIfExists(int $id): bool
    {
        $skillResult = $this->find($id);

        if ($skillResult instanceof SkillResult) {
            $this->remove($skillResult);
            $this->flush();

            return true;
        }

        return false;
    }
}