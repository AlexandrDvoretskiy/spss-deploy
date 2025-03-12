<?php

namespace App\Controller\Web\Mark\Create\v1;

use App\Controller\Web\Mark\Create\v1\Input\CreateMarkDTO;
use App\Controller\Web\Mark\Create\v1\Output\CreatedMarkDTO;
use App\Domain\Model\CreateMarkModel;
use App\Domain\Service\ModelFactory;
use App\Domain\Service\MarkService;

class Manager
{
    public function __construct(
        private readonly ModelFactory $modelFactory,
        private readonly MarkService $markService
    )
    {
    }

    public function create(CreateMarkDTO $createMarkDTO): CreatedMarkDTO
    {
        $createMarkModel = $this->modelFactory->makeModel(
            CreateMarkModel::class,
            $createMarkDTO->mark,
            $createMarkDTO->user,
            $createMarkDTO->task
        );
        $mark = $this->markService->create($createMarkModel);

        return new CreatedMarkDTO(
            $mark->getId(),
            $mark->getMark(),
            $mark->getUser(),
            $mark->getTask(),
            $mark->getCreatedAt()->format("d.m.Y H:i:s"),
            $mark->getUpdatedAt()->format("d.m.Y H:i:s"),
        );
    }
}