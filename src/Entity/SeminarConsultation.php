<?php

namespace App\Entity;

use App\Repository\SeminarConsultationRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\UniqueConstraint(name: 'unique_user_seminar', columns: ['user_id', 'seminar_id'])]
#[ORM\Entity(repositoryClass: SeminarConsultationRepository::class)]
class SeminarConsultation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $isToRead = false;

    #[ORM\Column]
    private ?bool $isFinished = false;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $lastConsultedAt = null;

    #[ORM\ManyToOne(inversedBy: 'seminarConsultations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?User $user = null;

    #[ORM\ManyToOne(inversedBy: 'seminarConsultations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Seminar $seminar = null;

    #[ORM\Column(nullable: true)]
    private ?array $finishedChapters = [];

    public function __toString()
    {
        return $_REQUEST['crudControllerFqcn'] == 'App\Controller\Admin\UserCrudController' ? $this->seminar->getTitle() : ($_REQUEST['crudControllerFqcn'] == 'App\Controller\Admin\SeminarCrudController' ?
            $this->user->getPrenom() . ' ' . $this->user->getNomNaissance() :
            $this->seminar->getTitle() . ' - ' . $this->user->getPrenom() . ' ' . $this->user->getNomNaissance());
    }

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

    public function setLastConsultedAtNow(): static
    {
        $this->lastConsultedAt = new \DateTimeImmutable();

        return $this;
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

    public function getFinishedChapters(): ?array
    {
        return $this->finishedChapters;
    }

    public function addFinishedChapter(int $id): static
    {
        $old = $this->finishedChapters ?? [];
        array_push($old, $id);
        $this->finishedChapters = array_unique($old);
        return $this;
    }

    public function markAllChaptersRead(): static
    {
        $all = [];
        foreach ($this->seminar->getChapters() as $id => $chapter) {
            $all[] = $id;
        }
        $this->finishedChapters = [...$all];
        return $this;
    }

    public function setFinishedChapters(?array $finishedChapters): static
    {
        $this->finishedChapters = $finishedChapters;

        return $this;
    }
}
