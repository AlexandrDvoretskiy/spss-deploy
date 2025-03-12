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

    public function find(int $id): Mark
    {
        return $this->entityManager->getRepository(Mark::class)->find($id);
    }

    public function deleteMarkIfExists(int $id): bool
    {
        $mark = $this->find($id);

        if ($mark instanceof Mark) {
            $this->remove($mark);
            $this->flush();

            return true;
        }

        return false;
    }

    public function updateMark(int $id, int $mark): bool
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->update(Mark::class, "m")
            ->setParameter("id", $id)
            ->setParameter("mark", $mark)
            ->set("m.mark", ":mark")
            ->where(
                $queryBuilder->expr()->eq("m.id", ":id")
            );

        return $queryBuilder->getQuery()->execute();
    }


}