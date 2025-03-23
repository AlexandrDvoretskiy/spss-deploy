<?php

namespace App\Controller\Web\User\Create\v2;

use App\Controller\Web\User\Create\v2\Input\CreateUserDTO;
use App\Controller\Web\User\Create\v2\Output\CreatedUserDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager,
    ) {
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route(path: 'api/user/v2/', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CreateUserDTO $createUserDTO): CreatedUserDTO
    {
        return $this->manager->create($createUserDTO);
    }
}