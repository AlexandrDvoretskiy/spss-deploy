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

    public function find(int $id): SkillRange
    {
        return $this->entityManager->getRepository(SkillRange::class)->find($id);
    }

    public function deleteSkillRangeIfExists(int $id): bool
    {
        $skillRange = $this->find($id);

        if ($skillRange instanceof SkillRange) {
            $this->remove($skillRange);
            $this->flush();

            return true;
        }

        return false;
    }

    public function updateSkillRange(int $id, int $skillRange): bool
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->update(SkillRange::class, "sr")
            ->setParameter("id", $id)
            ->setParameter("skillRange", $skillRange)
            ->set("sr.range", ":skillRange")
            ->where(
                $queryBuilder->expr()->eq("sr.id", ":id")
            );

        return $queryBuilder->getQuery()->execute();
    }

    public function findByTaskId(int $taskId): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();

        $queryBuilder->select('sr.id', 's.id AS skill', 'sr.range')
            ->from(SkillRange::class, 'sr')
            ->join('sr.skill', 's')
            ->where(
                $queryBuilder->expr()->eq('sr.task', ':taskId')
            )
            ->setParameter('taskId', $taskId)
            ->orderBy('sr.id', 'ASC');

        return $queryBuilder->getQuery()->enableResultCache(null, "skill_range_{$taskId}")->getResult();
    }

}