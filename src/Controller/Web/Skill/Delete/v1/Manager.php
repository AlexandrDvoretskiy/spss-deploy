<?php

namespace App\Controller\Web\Skill\Delete\v1;

use App\Domain\Model\CreateUserModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\SkillService;

class Manager
{
    public function __construct(
        /** @var ModelFactory<CreateUserModel> */
        private readonly SkillService $skillService,
    ) {
    }

    public function deleteSkillIfExists(int $id): bool
    {
        return $this->skillService->deleteSkillIfExists($id);
    }
}