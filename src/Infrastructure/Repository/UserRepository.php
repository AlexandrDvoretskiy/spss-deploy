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

    public function find(int $id): ?User
    {
        return $this->entityManager->getRepository(User::class)->find($id);
    }

    public function deleteUserIfExists(int $id): bool
    {
        $user = $this->find($id);

        if ($user instanceof User) {
            $this->remove($user);
            $this->flush();

            return true;
        }

        return false;
    }
}