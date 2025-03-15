<?php

namespace App\Domain\Service;

use App\Domain\Entity\User;
use App\Domain\Model\CreateUserModel;
use App\Infrastructure\Repository\UserRepository;

class UserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function create(CreateUserModel $createUserModel): User
    {
        $user = new User(
            $createUserModel->login
        );
        $this->userRepository->create($user);

        return $user;
    }

    public function findUserByLogin(string $login): array
    {
        $user = $this->userRepository->findUserByLogin($login);
    }

    public function findUserById(int $id): ?User
    {
        return $this->userRepository->find($id);
    }

    public function deleteUserIfExists(int $id): bool
    {
        return $this->userRepository->deleteUserIfExists($id);
    }


}