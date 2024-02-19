<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\SavedJobRepository;
use Doctrine\Common\Collections\Collection;

#[ORM\Entity(repositoryClass: SavedJobRepository::class)]
class SavedJob
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: "savedJobs")]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: JobPost::class, inversedBy: "savedJobs")]
    #[ORM\JoinColumn(nullable: false)]
    private $jobPost;




    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): static
    {
        $this->user = $user;

        return $this;
    }

    public function getJobPost(): ?JobPost
    {
        return $this->jobPost;
    }

    public function setJobPost(?JobPost $jobPost): static
    {
        $this->jobPost = $jobPost;

        return $this;
    }
}
