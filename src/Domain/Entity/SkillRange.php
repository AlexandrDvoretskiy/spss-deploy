<?php

namespace App\Domain\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'skill_range')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'skill_range__task_id__ind', columns: ['task_id'])]
#[ORM\Index(name: 'skill_range__skill_id__ind', columns: ['skill_id'])]
class SkillRange implements EntityInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: Task::class , inversedBy: 'ranges')]
    #[ORM\JoinColumn(name: 'task_id', referencedColumnName: 'id')]
    private Task $task;

    #[ORM\ManyToOne(targetEntity: Skill::class , inversedBy: 'ranges')]
    #[ORM\JoinColumn(name: 'skill_id', referencedColumnName: 'id')]
    private Skill $skill;

    #[ORM\Column(nullable: false)]
    private int $range;

    #[ORM\OneToMany(targetEntity: SkillResult::class, mappedBy: 'skillRange')]
    private Collection $results;

    #[ORM\Column(name: 'created_at', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', nullable: false)]
    private DateTime $updatedAt;

    public function __construct(
        Skill $skill,
        Task $task,
        int $range
    )
    {
        $this->skill = $skill;
        $this->task = $task;
        $this->range = $range;
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getCreatedAt(): DateTime {
        return $this->createdAt;
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
            'skill' => $this->getSkill(),
            'task' => $this->getTask(),
            'range' => $this->range,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }

    public function getInfo(): array
    {
        return [
            'id' => $this->id,
            'skill' => $this->getSkill(),
            'task' => $this->getTask(),
            'range' => $this->range,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @return Task
     */
    public function getTask(): array
    {
        return $this->task->getInfo();
    }

    /**
     * @return Skill
     */
    public function getSkill(): array
    {
        return $this->skill->getInfo();
    }

    /**
     * @return int
     */
    public function getRange(): int
    {
        return $this->range;
    }

    /**
     * @return Collection
     */
    public function getResults(): Collection
    {
        return $this->results;
    }
}