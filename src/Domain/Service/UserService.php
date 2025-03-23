<?php

namespace App\Domain\Service;

use App\Domain\Entity\User;
use App\Domain\Model\CreateUserModel;
use App\Infrastructure\Repository\UserRepository;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

class UserService
{
    public function __construct(
        private readonly UserRepository $userRepository,
        private readonly  UserPasswordHasherInterface $userPasswordHasher,
    )
    {
    }

    public function create(CreateUserModel $createUserModel): User
    {
        $user = new User(
            $createUserModel->login,
            $createUserModel->roles
        );
        $user->setPassword(
            $this->userPasswordHasher->hashPassword($user, $createUserModel->password)
        );
        $this->userRepository->create($user);

        return $user;
    }

    public function findUserByLogin(string $login): ?User
    {
        return $this->userRepository->findUserByLogin($login);
    }

    public function findUserById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function deleteUserIfExists(int $id): bool
    {
        return $this->userRepository->deleteUserIfExists($id);
    }

    public function updateToken(string $login): ?string
    {
        $user = $this->findUserByLogin($login);
        if ($user === null) {
            return null;
        }

        return $this->userRepository->updateToken(
            $user->getId(),
            $this->userRepository->generateToken()
        );
    }

    public function findUserByToken(string $token): ?User
    {
        return $this->userRepository->findUserByToken($token);
    }

    public function clearUserToken(string $login): void
    {
        $user = $this->findUserByLogin($login);
        if ($user !== null) {
            $this->userRepository->clearUserToken($user->getId());
        }
    }


}