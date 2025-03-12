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
#[ORM\Index(name: 'skill_result__skill_range__ind', columns: ['skill_range'])]
class SkillResult implements EntityInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class , inversedBy: 'skillResults')]
    #[ORM\JoinColumn(name: 'user_id', referencedColumnName: 'id')]
    private User $user;

    #[ORM\ManyToOne(targetEntity: SkillRange::class , inversedBy: 'results')]
    #[ORM\JoinColumn(name: 'skill_range', referencedColumnName: 'id')]
    private SkillRange $skillRange;

    #[ORM\Column(nullable: false)]
    private float $result;

    #[ORM\Column(name: 'created_at', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', nullable: false)]
    private DateTime $updatedAt;

    public function __construct(
        User $user,
        SkillRange $skillRange,
        float $result
    )
    {
        $this->user = $user;
        $this->skillRange = $skillRange;
        $this->result = $result;
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
            'user' => $this->getUser(),
            'skillRange' => $this->getSkillRange(),
            'result' => $this->result,
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
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
    public function getUser(): array
    {
        return $this->user->getInfo();
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

    /**
     * @return SkillRange
     */
    public function getSkillRange(): array
    {
        return $this->skillRange->getInfo();
    }
}