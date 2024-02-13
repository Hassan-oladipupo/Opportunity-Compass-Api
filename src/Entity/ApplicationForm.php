<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ApplicationFormRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: ApplicationFormRepository::class)]
class ApplicationForm
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    //Personal Information
    #[Assert\NotBlank(message: 'This field is required.')]
    #[ORM\Column(length: 255)]
    private ?string $fullName = null;

    #[Assert\NotBlank(message: 'This field is required.')]
    #[ORM\Column(length: 255)]
    private ?string $Email = null;

    #[Assert\NotBlank(message: 'This field is required.')]
    #[ORM\Column(length: 255)]
    private ?string $phoneNumber = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $Address = null;

    //Job Information
    #[Assert\NotBlank(message: 'This field is required.')]
    #[ORM\Column(length: 255)]
    private ?string $applyingPostion = null;

    #[Assert\NotBlank(message: 'This field is required.')]
    #[ORM\Column(length: 255)]
    private ?string $desiredSalary = null;

    #[Assert\NotBlank(message: 'This field is required.')]
    #[ORM\Column(length: 255)]
    private ?string $yearOfExperience = null;

    //Education
    #[Assert\NotBlank(message: 'This field is required.')]
    #[ORM\Column(length: 255)]
    private ?string $Qualification = null;

    #[Assert\NotBlank(message: 'This field is required.')]
    #[ORM\Column(length: 255)]
    private ?string $fieldOfStudy = null;



    //Skills & Qualifications:
    #[ORM\Column(length: 500, nullable: true)]
    private ?string $relevantSkills = null;

    //Uploads
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $coverLetter = null;

    #[Assert\NotBlank(message: 'This field is required.')]
    #[ORM\Column(length: 255)]
    private ?string $resume = null;

    #[ORM\ManyToOne(targetEntity: User::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $applicant;

    #[ORM\ManyToOne(targetEntity: JobPost::class)]
    #[ORM\JoinColumn(nullable: false)]
    private ?JobPost $relatedJobPost;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $createdate = null;


    public function __construct()
    {
        $this->relatedJobPost = new ArrayCollection();
        $this->applicant = new ArrayCollection();
        $this->createdate = new DateTime();
    }

    public function getId(): ?int
    {

        return $this->id;
    }

    public function getFullName(): ?string
    {
        return $this->fullName;
    }

    public function setFullName(string $fullName): static
    {
        $this->fullName = $fullName;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): static
    {
        $this->Email = $Email;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

        return $this;
    }

    public function getAddress(): ?string
    {
        return $this->Address;
    }

    public function setAddress(?string $Address): static
    {
        $this->Address = $Address;

        return $this;
    }

    public function getApplyingPostion(): ?string
    {
        return $this->applyingPostion;
    }

    public function setApplyingPostion(string $applyingPostion): static
    {
        $this->applyingPostion = $applyingPostion;

        return $this;
    }

    public function getDesiredSalary(): ?string
    {
        return $this->desiredSalary;
    }

    public function setDesiredSalary(string $desiredSalary): static
    {
        $this->desiredSalary = $desiredSalary;

        return $this;
    }

    public function getQualification(): ?string
    {
        return $this->Qualification;
    }

    public function setQualification(string $Qualification): static
    {
        $this->Qualification = $Qualification;

        return $this;
    }

    public function getFieldOfStudy(): ?string
    {
        return $this->fieldOfStudy;
    }

    public function setFieldOfStudy(string $fieldOfStudy): static
    {
        $this->fieldOfStudy = $fieldOfStudy;

        return $this;
    }

    public function getYearOfExperience(): ?string
    {
        return $this->yearOfExperience;
    }

    public function setYearOfExperience(string $yearOfExperience): static
    {
        $this->yearOfExperience = $yearOfExperience;

        return $this;
    }

    public function getRelevantSkills(): ?string
    {
        return $this->relevantSkills;
    }

    public function setRelevantSkills(?string $relevantSkills): static
    {
        $this->relevantSkills = $relevantSkills;

        return $this;
    }

    public function getcoverLetter(): ?string
    {
        return $this->coverLetter;
    }

    public function setcoverLetter(?string $coverLetter): static
    {
        $this->coverLetter = $coverLetter;

        return $this;
    }

    public function getresume(): ?string
    {
        return $this->resume;
    }

    public function setresume(?string $resume): static
    {
        $this->resume = $resume;

        return $this;
    }

    public function getApplicant(): ?User
    {
        return $this->applicant;
    }

    public function setApplicant(?User $applicant): void
    {
        $this->applicant = $applicant;
    }

    public function getRelatedJobPost(): ?JobPost
    {
        return $this->relatedJobPost;
    }

    public function setRelatedJobPost(?JobPost $relatedJobPost): void
    {
        $this->relatedJobPost = $relatedJobPost;
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
}
