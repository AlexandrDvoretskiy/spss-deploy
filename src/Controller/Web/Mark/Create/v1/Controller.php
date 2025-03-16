<?php

namespace App\Controller\Web\Mark\Create\v1;

use App\Controller\Web\Mark\Create\v1\Input\CreateMarkDTO;
use App\Controller\Web\Mark\Create\v1\Output\CreatedMarkDTO;
use Symfony\Component\HttpKernel\Attribute\AsController;
use Symfony\Component\HttpKernel\Attribute\MapRequestPayload;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[AsController]
class Controller
{
    public function __construct(
        private readonly Manager $manager
    ) {
    }

    #[IsGranted("ROLE_ADMIN")]
    #[Route(path: "api/mark/v1/", methods: ["POST"])]
    public function __invoke(#[MapRequestPayload] CreateMarkDTO $createMarkDTO): CreatedMarkDTO
    {
        return $this->manager->create($createMarkDTO);
    }

}