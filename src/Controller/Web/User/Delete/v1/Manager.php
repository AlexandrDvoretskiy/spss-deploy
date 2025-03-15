<?php

namespace App\Controller\Web\User\Delete\v1;

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

    public function deleteUserIfExists(int $id): bool
    {
        return $this->userService->deleteUserIfExists($id);
    }
}