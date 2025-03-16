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

    public function findUserByLogin(string $login): ?User
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->select('u')
            ->from(User::class, 'u')
            ->andWhere(
                $queryBuilder->expr()->eq('u.login',':userLogin')
            )
            ->setParameter('userLogin', $login);

        return $queryBuilder->getQuery()->getOneOrNullResult();
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

    public function updateToken(int $id, ?string $token = null): ?string
    {
        $queryBuilder = $this->entityManager->createQueryBuilder();
        $queryBuilder->update(User::class, "u")
            ->setParameter("id", $id)
            ->setParameter("token", $token)
            ->set("u.token", ":token")
            ->where(
                $queryBuilder->expr()->eq("u.id", ":id")
            );
        $queryBuilder->getQuery()->execute();

        return $token;
    }

    public function generateToken(): string
    {
        return base64_encode(random_bytes(20));
    }

    public function findUserByToken(string $token): ?User
    {
        /** @var User|null $user */
        $user = $this->entityManager->getRepository(User::class)->findOneBy(['token' => $token]);

        return $user;
    }

    public function clearUserToken($id): void
    {
        $this->updateToken($id, null);
    }
}