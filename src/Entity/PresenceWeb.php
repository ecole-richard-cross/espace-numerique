<?php

namespace App\Entity;

use App\Repository\PresenceWebRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PresenceWebRepository::class)]
class PresenceWeb
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\ManyToOne(inversedBy: 'presenceWebs')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stagiaire $stagiaire = null;

    public function __toString()
    {
        return $this->url;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getType(): ?string
    {
        return $this->type;
    }

    public function setType(string $type): static
    {
        $this->type = $type;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(string $url): static
    {
        $this->url = $url;

        return $this;
    }

    public function getStagiaire(): ?Stagiaire
    {
        return $this->stagiaire;
    }

    public function setStagiaire(?Stagiaire $stagiaire): static
    {
        $this->stagiaire = $stagiaire;

        return $this;
    }
}
