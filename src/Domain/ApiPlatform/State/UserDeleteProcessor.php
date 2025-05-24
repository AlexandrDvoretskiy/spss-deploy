<?php

namespace App\Domain\ApiPlatform\State;

use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Operation;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Service\UserService;

class UserDeleteProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly UserService $userService
    )
    {
    }

    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): bool|null
    {
        if ($operation instanceof Delete) {
            $id = $uriVariables["id"];
            if (is_numeric($id)) {
                return $this->userService->deleteUserIfExists($id);
            }
        }

        return null;
    }
}