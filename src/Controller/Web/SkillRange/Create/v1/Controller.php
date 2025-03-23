<?php

namespace App\Controller\Web\SkillRange\Create\v1;

use App\Controller\Web\SkillRange\Create\v1\Input\CreateSkillRangeDTO;
use App\Controller\Web\SkillRange\Create\v1\Output\CreatedSkillRangeDTO;
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
    #[Route(path: "api/skill-range/v1/", methods: ["POST"])]
    public function __invoke(#[MapRequestPayload] CreateSkillRangeDTO $createSkillRangeDTO): CreatedSkillRangeDTO
    {
        return $this->manager->create($createSkillRangeDTO);
    }

}