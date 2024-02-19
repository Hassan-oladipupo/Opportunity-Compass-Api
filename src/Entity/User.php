<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[ORM\Table(name: '`user`')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $username = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'First name should not be blank.')]
    private ?string $firstName = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Last name should not be blank.')]
    private ?string $lastName = null;

    #[ORM\Column(type: 'json')]
    private array $roles = [];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToOne(mappedBy: 'user', cascade: ['persist', 'remove'])]
    private ?UserProfile $userProfile = null;

    #[ORM\Column(type: 'string', length: 255, nullable: true)]
    private ?string $confirmationToken;

    #[ORM\Column(type: 'boolean')]
    private bool $confirmed = false;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: JobPost::class, orphanRemoval: true)]
    #[Groups(["user:read"])]
    private Collection $jobPosts;

    #[ORM\OneToMany(mappedBy: 'User', targetEntity: SavedJob::class, orphanRemoval: true)]
    private Collection $savedJobs;

    public function __construct()
    {
        $this->jobPosts = new ArrayCollection();
        $this->savedJobs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): static
    {
        $this->username = $username;

        return $this;
    }

    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    public function setFirstName(string $firstName): static
    {
        $this->firstName = $firstName;

        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->lastName;
    }

    public function setLastName(string $lastName): static
    {
        $this->lastName = $lastName;

        return $this;
    }

    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    public function getConfirmationToken(): ?string
    {
        return $this->confirmationToken;
    }

    public function setConfirmationToken(?string $confirmationToken): void
    {
        $this->confirmationToken = $confirmationToken;
    }

    public function isConfirmed(): bool
    {
        return $this->confirmed;
    }

    public function setConfirmed(bool $confirmed): void
    {
        $this->confirmed = $confirmed;
    }

    /**
     * @return Collection<int, JobPost>
     */
    public function getJobPosts(): Collection
    {
        return $this->jobPosts;
    }

    public function addJobPost(JobPost $jobPost): self
    {
        if (!$this->jobPosts->contains($jobPost)) {
            $this->jobPosts[] = $jobPost;
            $jobPost->setUser($this);
        }
        return $this;
    }

    public function removeJobPost(JobPost $jobPost): self
    {
        if ($this->jobPosts->removeElement($jobPost)) {
            if ($jobPost->getUser() === $this) {
                $jobPost->setUser(null);
            }
        }
        return $this;
    }

    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
    }

    public function getUserIdentifier(): string
    {
        return (string) $this->username;
    }

    public function getUserProfile(): ?UserProfile
    {
        return $this->userProfile;
    }

    public function setUserProfile(UserProfile $userProfile): static
    {
        // set the owning side of the relation if necessary
        if ($userProfile->getUser() !== $this) {
            $userProfile->setUser($this);
        }

        $this->userProfile = $userProfile;

        return $this;
    }

    /**
     * @return Collection<int, SavedJob>
     */
    public function getSavedJobs(): Collection
    {
        return $this->savedJobs;
    }

    


    public function addSavedJob(SavedJob $savedJob): static
    {
        if (!$this->savedJobs->contains($savedJob)) {
            $this->savedJobs->add($savedJob);
            $savedJob->setUser($this);
        }

        return $this;
    }

    public function removeSavedJob(SavedJob $savedJob): static
    {
        if ($this->savedJobs->removeElement($savedJob)) {
            // set the owning side to null (unless already changed)
            if ($savedJob->getUser() === $this) {
                $savedJob->setUser(null);
            }
        }

        return $this;
    }
}
