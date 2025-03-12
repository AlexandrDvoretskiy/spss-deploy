<?php

namespace App\Domain\Entity;

use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Table(name: '`user`')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
class User implements EntityInterface
{
    #[ORM\Column(name: 'id', type: 'bigint', unique: true)]
    #[ORM\Id]
    #[ORM\GeneratedValue(strategy: 'IDENTITY')]
    private ?int $id = null;

    #[ORM\Column(length: 32, nullable: false)]
    private string $login;

    #[ORM\OneToMany(targetEntity: Mark::class, mappedBy: 'user')]
    private Collection $marks;

    #[ORM\OneToMany(targetEntity: SkillResult::class, mappedBy: 'user')]
    private Collection $skillResults;

    #[ORM\Column(name: 'created_at', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', nullable: false)]
    private DateTime $updatedAt;

    public function __construct(
        string $login,
    )
    {
        $this->login = $login;

        $this->marks = new ArrayCollection();
        $this->skillResults = new ArrayCollection();
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getLogin(): string
    {
        return $this->login;
    }

    public function setLogin(string $login): void
    {
        $this->login = $login;
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

    /* ------------------------------------------------------------------ */

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
            'marks' => array_map(static fn(Mark $mark) => $mark->toArray(), $this->marks->toArray()),
            'skillResults' => array_map(static fn(SkillResult $result) => $result->toArray(), $this->skillResults->toArray()),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }

    public function getInfo(): array
    {
        return [
            'id' => $this->id,
            'login' => $this->login,
//            'marks' => array_map(static fn(Mark $mark) => $mark->toArray(), $this->marks->toArray()),
//            'skillResults' => array_map(static fn(SkillResult $result) => $result->toArray(), $this->skillResults->toArray()),
            'createdAt' => $this->createdAt->format('Y-m-d H:i:s'),
            'updatedAt' => $this->updatedAt->format('Y-m-d H:i:s'),
        ];
    }

    /**
     * @return Collection
     */
    public function getMarks(): Collection
    {
        return $this->marks;
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
    public function getSkillResults(): Collection
    {
        return $this->skillResults;
    }

    /**
     * @param Collection $skillResults
     */
    public function setSkillResults(Collection $skillResult): void
    {
        if (!$this->skillResults->contains($skillResult)) {
            $this->skillResults->add($skillResult);
        }
    }
}