<?php

namespace App\Controller\Web\User\Get\v1;

use App\Domain\Entity\User;
use App\Domain\Model\CreateUserModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\UserService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateUserModel> */
        private readonly ModelFactory $modelFactory,
        private readonly UserService $userService,
    ) {
    }

    public function getUserById(int $userId): ?User
    {
        return $this->userService->findUserById($userId);
    }
}