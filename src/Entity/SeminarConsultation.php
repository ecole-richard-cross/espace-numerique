<?php

namespace App\Entity;

use App\Repository\SeminarConsultationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: SeminarConsultationRepository::class)]
class SeminarConsultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isToRead = null;

    #[ORM\Column]
    private ?bool $isFinished = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastConsultedAt = null;

    #[ORM\ManyToOne(inversedBy: 'seminarConsultations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'seminarConsultations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Seminar $seminar = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isIsToRead(): ?bool
    {
        return $this->isToRead;
    }

    public function setIsToRead(bool $isToRead): static
    {
        $this->isToRead = $isToRead;

        return $this;
    }

    public function isIsFinished(): ?bool
    {
        return $this->isFinished;
    }

    public function setIsFinished(bool $isFinished): static
    {
        $this->isFinished = $isFinished;

        return $this;
    }

    public function getLastConsultedAt(): ?\DateTimeImmutable
    {
        return $this->lastConsultedAt;
    }

    public function setLastConsultedAt(?\DateTimeImmutable $lastConsultedAt): static
    {
        $this->lastConsultedAt = $lastConsultedAt;

        return $this;
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

    public function getSeminar(): ?Seminar
    {
        return $this->seminar;
    }

    public function setSeminar(?Seminar $seminar): static
    {
        $this->seminar = $seminar;

        return $this;
    }
}
