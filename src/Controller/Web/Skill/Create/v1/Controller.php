<?php

namespace App\Controller\Web\Skill\Create\v1;

use App\Controller\Web\Skill\Create\v1\Input\CreateSkillDTO;
use App\Controller\Web\Skill\Create\v1\Output\CreatedSkillDTO;
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
    #[Route(path: 'api/skill/v1/', methods: ['POST'])]
    public function __invoke(#[MapRequestPayload] CreateSkillDTO $createSkillDTO): CreatedSkillDTO
    {
        return $this->manager->create($createSkillDTO);
    }
}