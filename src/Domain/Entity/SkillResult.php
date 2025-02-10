<?php

namespace App\Domain\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: 'skill_result')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ORM\Index(name: 'skill_result__user_id__ind', columns: ['user_id'])]
#[ORM\Index(name: 'skill_result__task_id__ind', columns: ['task_id'])]
#[ORM\Index(name: 'skill_result__skill_id__ind', columns: ['skill_id'])]
class SkillResult implements EntityInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class , inversedBy: 'skillResults')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    #[ORM\ManyToOne(targetEntity: Task::class , inversedBy: 'skillResults')]
    #[ORM\JoinColumn(name: 'task_id', referencedColumnName: 'id')]
    private Task $task;

    #[ORM\ManyToOne(targetEntity: Skill::class , inversedBy: 'results')]
    #[ORM\JoinColumn(name: 'skill_id', referencedColumnName: 'id')]
    private Skill $skill;

    #[ORM\Column(type: 'float', nullable: false)]
    private float $result;

    #[ORM\Column(name: 'created_at', type: 'datetime', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', type: 'datetime', nullable: false)]
    private DateTime $updatedAt;

    public function __construct()
    {
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
            'user' => $this->user,
            'task' => $this->task,
            'skill' => $this->skill,
            'result' => $this->result,
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
     * @return Skill
     */
    public function getSkill(): Skill
    {
        return $this->skill;
    }

    /**
     * @param Skill $skill
     */
    public function setSkill(Skill $skill): void
    {
        $this->skill = $skill;
    }

    /**
     * @return int
     */
    public function getRange(): int
    {
        return $this->range;
    }

    /**
     * @param int $range
     */
    public function setRange(int $range): void
    {
        $this->range = $range;
    }

    /**
     * @return User
     */
    public function getUser(): User
    {
        return $this->user;
    }

    /**
     * @param User $user
     */
    public function setUser(User $user): void
    {
        $this->user = $user;
    }

    /**
     * @return float
     */
    public function getResult(): float
    {
        return $this->result;
    }

    /**
     * @param float $result
     */
    public function setResult(float $result): void
    {
        $this->result = $result;
    }
}