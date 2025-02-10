<?php

namespace App\Domain\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'skill')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'skill__task_id__ind', columns: ['task_id'])]
class Skill implements EntityInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(type: 'string', length: 32, nullable: false)]
    private string $title;

    #[ORM\ManyToOne(targetEntity: Task::class , inversedBy: 'skills')]
    #[ORM\JoinColumn(name: 'task_id', referencedColumnName: 'id')]
    private Task $task;

    #[ORM\OneToMany(targetEntity: SkillRange::class, mappedBy: 'skill')]
    private Collection $ranges;

    #[ORM\OneToMany(targetEntity: SkillResult::class, mappedBy: 'skill')]
    private Collection $results;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;

    public function __construct()
    {
        $this->ranges = new ArrayCollection();
        $this->results = new ArrayCollection();
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
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

    #[ORM\PrePersist]
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
            'task' => $this->task,
            'ranges' => array_map(static fn(SkillRange $range) => $range->toArray(), $this->ranges->toArray()),
            'results' => array_map(static fn(SkillResult $result) => $result->toArray(), $this->results->toArray()),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @return Task
     */
    public function getTask(): Task
    {
        return $this->task;
    }

    /**
     * @param Task $task
     */
    public function setTask(Task $task): void
    {
        $this->task = $task;
    }

    /**
     * @return Collection
     */
    public function getRanges(): Collection
    {
        return $this->ranges;
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

    /**
     * @return Collection
     */
    public function getResults(): Collection
    {
        return $this->results;
    }

    /**
     * @param Collection $result
     */
    public function setResults(Collection $result): void
    {
        if (!$this->results->contains($result)) {
            $this->results->add($result);
        }
    }
}