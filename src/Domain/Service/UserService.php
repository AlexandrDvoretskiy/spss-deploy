<?php

namespace App\Domain\Service;

use App\Domain\Entity\User;
use App\Infrastructure\Repository\UserRepository;

class UserService
{
    public function __construct(private readonly UserRepository $userRepository)
    {
    }

    public function create(string $login): User
    {
        $user = new User();
        $user->setLogin($login);
        $this->userRepository->create($user);

        return $user;
    }

    public function findUserByLogin(string $login): array
    {
        return $this->userRepository->findUserByLogin($login);
    }


}