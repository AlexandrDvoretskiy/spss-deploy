<?php

namespace App\Domain\ApiPlatform\State;

use ApiPlatform\Metadata\Operation;
use ApiPlatform\Metadata\Post;
use ApiPlatform\State\ProcessorInterface;
use App\Domain\Model\CreateUserModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\UserService;
use App\Domain\ApiPlatform\DTO\Input\CreateUserDTO;
use App\Domain\ApiPlatform\DTO\Output\CreatedUserDTO;

/**
 * @implements ProcessorInterface<CreateUserDTO, CreatedUserDTO|void>
 */
class UserProcessor implements ProcessorInterface
{
    public function __construct(
        private readonly ModelFactory $modelFactory,
        private readonly UserService $userService
    ) {
    }

    /**
     * @param CreateUserDTO $data
     * @return CreatedUserDTO|void
     */
    public function process(mixed $data, Operation $operation, array $uriVariables = [], array $context = []): CreatedUserDTO
    {
        if ($operation instanceof Post) {
            $userModel = $this->modelFactory->makeModel(
                CreateUserModel::class,
                $data->login,
                $data->password,
                $data->roles,
            );

            $user = $this->userService->create($userModel);
        }

        return new CreatedUserDTO(
            $user->getId(),
            $user->getLogin(),
            $user->getRoles(),
            $user->getCreatedAt()->format('Y-m-d H:i:s'),
            $user->getUpdatedAt()->format('Y-m-d H:i:s'),
        );
    }
}