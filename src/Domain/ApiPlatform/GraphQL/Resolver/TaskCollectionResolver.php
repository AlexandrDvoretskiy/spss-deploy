<?php

namespace App\Domain\ApiPlatform\GraphQL\Resolver;

use ApiPlatform\GraphQl\Resolver\QueryCollectionResolverInterface;
use App\Domain\Entity\Task;

class TaskCollectionResolver implements QueryCollectionResolverInterface
{

    public function __invoke(iterable $collection, array $context): iterable
    {
        /** @var Task $task */
        foreach ($collection as $task) {
            $task->setTitle("---");
        }

        return $collection;
    }
}