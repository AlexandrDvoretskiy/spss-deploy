<?php

namespace App\Controller\Web\User\Delete\v1;

use App\Domain\Entity\User;
use App\Domain\Model\CreateUserModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\UserService;
use http\Env\Response;

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