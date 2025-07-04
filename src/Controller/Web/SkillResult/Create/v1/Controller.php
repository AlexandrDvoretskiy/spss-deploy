<?php

namespace App\Controller\Web\SkillResult\Create\v1;

use App\Controller\Web\SkillResult\Create\v1\Input\CreateSkillResultDTO;
use App\Controller\Web\SkillResult\Create\v1\Output\CreatedSkillResultDTO;
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
    #[Route(path: "api/skill-result/v1/", methods: ["POST"])]
    public function __invoke(#[MapRequestPayload] CreateSkillResultDTO $createSkillResultDTO): CreatedSkillResultDTO
    {
        return $this->manager->create($createSkillResultDTO);
    }

}