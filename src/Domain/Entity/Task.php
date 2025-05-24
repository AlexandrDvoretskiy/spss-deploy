<?php

namespace App\Domain\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\GraphQl\QueryCollection;
use App\Domain\ApiPlatform\GraphQL\Resolver\TaskCollectionResolver;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'task')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'task__lesson_id__ind', columns: ['lesson_id'])]
#[ApiResource(
    graphQlOperations: [
        new QueryCollection(),
        new QueryCollection(resolver: TaskCollectionResolver::class, name: 'protected'),
    ]
)]
#[ApiFilter(SearchFilter::class, properties: ['title' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['id', 'title'])]
class Task implements EntityInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 32, nullable: false)]
    private string $title;

    #[ORM\ManyToOne(targetEntity: Lesson::class , inversedBy: 'tasks')]
    #[ORM\JoinColumn(name: 'lesson_id', referencedColumnName: 'id')]
    private Lesson $lesson;

    #[ORM\OneToMany(targetEntity: Mark::class, mappedBy: 'task')]
    private Collection $marks;

    #[ORM\OneToMany(targetEntity: SkillRange::class, mappedBy: 'task')]
    private Collection $ranges;

    #[ORM\Column(name: 'created_at', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', nullable: false)]
    private DateTime $updatedAt;

    public function __construct(
        string $title,
        Lesson $lesson
    )
    {
        $this->title = $title;
        $this->lesson = $lesson;

        $this->marks = new ArrayCollection();
        $this->ranges = new ArrayCollection();
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getTitle(): string
    {
        return $this->title;
    }

    public function setTitle(string $title): void
    {
        $this->title = $title;
    }

    public function getCreatedAt(): DateTime {
        return $this->createdAt;
    }

    public function setCreatedAt(): void {
        $this->createdAt = new DateTime();
    }

    public function getUpdatedAt(): DateTime {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAt(): void {
        $this->updatedAt = new DateTime();
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'lesson' => $this->getLessonInfo(),
            'ranges' => array_map(static fn(SkillRange $range) => $range->toArray(), $this->ranges->toArray()),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }

    public function getInfo(): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'lesson' => $this->getLessonInfo(),
            // 'ranges' => array_map(static fn(SkillRange $range) => $range->toArray(), $this->ranges->toArray()),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @return Lesson
     */
    public function getLesson(): Lesson
    {
        return $this->lesson;
    }

    public function addSkill(Skill $skill): void
    {
        if (!$this->skills->contains($skill)) {
            $this->skills->add($skill);
        }
    }

    /**
     * @return Collection
     */
    public function getSkills(): array
    {
        return array_map(static fn(Skill $skill) => $skill->toArray(), $this->skills->toArray());
    }

    /**
     * @param Collection $skills
     */
    public function setSkills(Collection $skills): void
    {
        $this->skills = $skills;
    }

    /**
     * @return Collection
     */
    public function getMarks(): array
    {
        return array_map(static fn(Mark $mark) => $mark->toArray(), $this->marks->toArray());
    }

    /**
     * @param Collection $marks
     */
    public function setMarks(Collection $mark): void
    {
        if (!$this->marks->contains($mark)) {
            $this->marks->add($mark);
        }
    }

    /**
     * @return Collection
     */
    public function getRanges(): array
    {
        return array_map(static fn(SkillRange $skillRange) => $skillRange->toArray(), $this->ranges->toArray());
    }

    /**
     * @param Collection $range
     */
    public function setRanges(Collection $range): void
    {
        if (!$this->ranges->contains($range)) {
            $this->ranges->add($range);
        }
    }

    public function getLessonInfo(): array
    {
        return $this->lesson->getInfo();
    }
}