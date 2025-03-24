<?php

namespace App\Domain\Entity;

use ApiPlatform\Doctrine\Orm\Filter\OrderFilter;
use ApiPlatform\Doctrine\Orm\Filter\SearchFilter;
use ApiPlatform\Metadata\ApiFilter;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Delete;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use App\Domain\ApiPlatform\DTO\Input\CreateUserDTO;
use App\Domain\ApiPlatform\DTO\Output\CreatedUserDTO;
use App\Domain\ApiPlatform\State\UserDeleteProcessor;
use App\Domain\ApiPlatform\State\UserProcessor;
use App\Domain\ApiPlatform\State\UserProviderDecorator;
use App\Domain\ValueObject\RoleEnum;
use DateTime;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;

#[ORM\Table(name: '`user`')]
#[ORM\Entity]
#[ORM\HasLifecycleCallbacks]
#[ApiResource]
#[Post(input: CreateUserDTO::class, output: CreatedUserDTO::class, processor: UserProcessor::class)]
#[Get(output: CreatedUserDTO::class, provider: UserProviderDecorator::class)]
#[Delete(processor: UserDeleteProcessor::class)]
#[ApiFilter(SearchFilter::class, properties: ['login' => 'partial'])]
#[ApiFilter(OrderFilter::class, properties: ['id', 'title'])]
class User implements EntityInterface, UserInterface, PasswordAuthenticatedUserInterface
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

    #[ORM\Column(type: 'json', length: 1024, nullable: false)]
    private array $roles = [];

    #[ORM\Column(nullable: false)]
    private string $password;

    #[ORM\Column(length: 32, unique: true, nullable: true)]
    private ?string $token = null;

    #[ORM\Column(name: 'created_at', nullable: false)]
    private DateTime $createdAt;

    #[ORM\Column(name: 'updated_at', nullable: false)]
    private DateTime $updatedAt;

    public function __construct(
        string $login,
        array $roles
    )
    {
        $this->login = $login;
        $this->roles = $roles;

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

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string[]
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = RoleEnum::ROLE_USER->value;

        return array_unique($roles);
    }

    /**
     * @param string[] $roles
     */
    public function setRoles(array $roles): void
    {
        $this->roles = $roles;
    }

    public function eraseCredentials(): void
    {
    }

    public function getUserIdentifier(): string
    {
        return $this->login;
    }

    public function getToken(): ?string
    {
        return $this->token;
    }

    public function setToken(?string $token): void
    {
        $this->token = $token;
    }
}