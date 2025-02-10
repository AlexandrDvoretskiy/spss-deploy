<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\User;
use Doctrine\Common\Collections\Criteria;
use Doctrine\ORM\AbstractQuery;

/**
 * @extends AbstractRepository<User>
 */
class UserRepository extends AbstractRepository
{
    public function create(User $user): int
    {
        return $this->store($user);
    }

    public function findUserByLogin(string $login): array
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->andWhere(
                $queryBuilder->expr()->eq('u.login',':userLogin')
            )
            ->setParameter('userLogin', "$login");

        return $queryBuilder->getQuery()->getResult();
    }
}