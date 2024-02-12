<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\JobPostRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Serializer\Annotation\Groups;

use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: JobPostRepository::class)]
class JobPost
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups("jobPost")]
    private ?int $id = null;

    #[Assert\NotBlank(message: 'Job title should not be blank.')]
    #[ORM\Column(length: 255)]
    #[Groups("jobPost")]
    private ?string $jobTitle = null;

    #[Assert\NotBlank(message: 'Job description should not be blank.')]
    #[Assert\Length(min: 5, max: 5000, minMessage: 'Job description is too short, 20 characters is the minimum.')]
    #[ORM\Column(length: 5000)]
    #[Groups("jobPost")]
    private ?string $jobDescription = null;

    #[ORM\Column(length: 255)]
    #[Groups("jobPost")]
    #[Assert\NotBlank(message: 'Location should not be blank.')]
    private ?string $jobLocation = null;

    #[ORM\Column(length: 255)]
    #[Groups("jobPost")]
    #[Assert\NotBlank(message: 'Job requirement should not be blank.')]
    private ?string $jobRequirement = null;

    #[ORM\Column(length: 255)]
    #[Assert\NotBlank(message: 'Please select a category.')]
    #[Groups("jobPost")]
    private ?string $jobCategory = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups("jobPost")]
    private ?\DateTimeInterface $createdate = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'jobPosts')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups("jobPost")]
    private ?User $user = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: JobPost::class, orphanRemoval: true)]
    private Collection $jobPosts;

    public function __construct()
    {
        $this->jobPosts = new ArrayCollection();
        $this->createdate = new DateTime();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getJobTitle(): ?string
    {
        return $this->jobTitle;
    }

    public function setJobTitle(string $jobTitle): static
    {
        $this->jobTitle = $jobTitle;

        return $this;
    }

    public function getJobDescription(): ?string
    {
        return $this->jobDescription;
    }

    public function setJobDescription(string $jobDescription): static
    {
        $this->jobDescription = $jobDescription;

        return $this;
    }

    public function getJobLocation(): ?string
    {
        return $this->jobLocation;
    }

    public function setJobLocation(string $jobLocation): static
    {
        $this->jobLocation = $jobLocation;

        return $this;
    }

    public function getJobRequirement(): ?string
    {
        return $this->jobRequirement;
    }

    public function setJobRequirement(string $jobRequirement): static
    {
        $this->jobRequirement = $jobRequirement;

        return $this;
    }

    public function getJobCategory(): ?string
    {
        return $this->jobCategory;
    }

    public function setJobCategory(string $jobCategory): static
    {
        $this->jobCategory = $jobCategory;

        return $this;
    }

    public function getCreatedate(): ?\DateTimeInterface
    {
        return $this->createdate;
    }

    public function setCreatedate(\DateTimeInterface $createdate): static
    {
        $this->createdate = $createdate;

        return $this;
    }

    #[Groups(["job_post:write"])]
    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;
        return $this;
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
            $this->jobPosts->add($jobPost);
            $jobPost->setUser($this->getUser()); // Set the user of the job post to the current user
        }
        return $this;
    }


    public function removeJobPost(JobPost $jobPost): self
    {
        if ($this->jobPosts->removeElement($jobPost)) {
            // set the owning side to null (unless already changed)
            if ($jobPost->getUser() === $this) {
                $jobPost->setUser(null);
            }
        }
        return $this;
    }
}
