<?php

namespace App\Infrastructure\Repository;

use App\Domain\Entity\Lesson;
use App\Domain\Model\ListItemLessonModel;
use App\Domain\Repository\LessonRepositoryInterface;
use Psr\Cache\InvalidArgumentException;
use Symfony\Contracts\Cache\ItemInterface;
use Symfony\Contracts\Cache\TagAwareCacheInterface;

class LessonRepositoryCacheDecorator implements LessonRepositoryInterface
{

    public function __construct(
        private readonly LessonRepository $lessonRepository,
        private readonly TagAwareCacheInterface $cache,
    ) {
    }

    /**
     * @throws InvalidArgumentException
     */
    public function create(Lesson $lesson): int
    {
        $result = $this->lessonRepository->create($lesson);
        $this->cache->invalidateTags([$this->getCacheTag()]);

       return $result;
    }


    /**
     * @throws InvalidArgumentException
     */
    public function getList(int $page, int $perPage): array
    {
        return $this->cache->get(
            $this->getCacheKey($page, $perPage),

            function (ItemInterface $item) use ($page, $perPage) {
                $lessons = $this->lessonRepository->getList($page, $perPage);

                $lessonModels = array_map(
                    static fn (Lesson $lesson): ListItemLessonModel => new ListItemLessonModel(
                        $lesson->getId(),
                        $lesson->getTitle(),
                        $lesson->getCreatedAt()->format('Y-m-d H:i:s'),
                    ),
                    $lessons
                );

                $item->set($lessonModels);
                $item->tag($this->getCacheTag());

                return $lessonModels;
            }
        );
    }

    public function getCacheKey(int $page, int $perPage): string
    {
        return "lesson_{$page}_$perPage";
    }

    public function getCacheTag(): string
    {
        return 'lessons';
    }
}