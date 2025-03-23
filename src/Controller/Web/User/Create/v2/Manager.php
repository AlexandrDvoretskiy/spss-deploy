<?php

namespace App\Controller\Web\User\Create\v2;

use App\Controller\Web\User\Create\v2\Input\CreateUserDTO;
use App\Controller\Web\User\Create\v2\Output\CreatedUserDTO;
use App\Domain\Entity\EmailUser;
use App\Domain\Entity\PhoneUser;
use App\Domain\Entity\User;
use App\Domain\Model\CreateUserModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\UserService;
use App\Domain\ValueObject\CommunicationChannelEnum;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateUserModel> */
        private readonly ModelFactory $modelFactory,
        private readonly UserService $userService,
    ) {
    }

    public function create(CreateUserDTO $createUserDTO): CreatedUserDTO
    {
        $createUserModel = $this->modelFactory->makeModel(
            CreateUserModel::class,
            $createUserDTO->login,
            $createUserDTO->password,
            $createUserDTO->roles,
        );
        $user = $this->userService->create($createUserModel);

        return new CreatedUserDTO(
            $user->getId(),
            $user->getLogin(),
            $user->getRoles(),
            $user->getCreatedAt()->format('Y-m-d H:i:s'),
            $user->getUpdatedAt()->format('Y-m-d H:i:s'),
        );
    }
}