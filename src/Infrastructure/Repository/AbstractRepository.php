<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\EntityInterface;
use Doctrine\ORM\EntityManagerInterface;

/**
 * @template T
 */
abstract class AbstractRepository
{
    public function __construct(protected readonly EntityManagerInterface $entityManager)
    {
    }

    protected function flush(): void
    {
        $this->entityManager->flush();
    }

    /**
     * @param T $entity
     */
    protected function store(EntityInterface $entity): int
    {
        $this->entityManager->persist($entity);
        $this->flush();

        return $entity->getId();
    }

    /**
     * @param T $entity
     * @throws ORMException
     */
    public function refresh(EntityInterface $entity): void
    {
        $this->entityManager->refresh($entity);
    }

    public function remove(EntityInterface $entity): void
    {
        $this->entityManager->remove($entity);
    }
}