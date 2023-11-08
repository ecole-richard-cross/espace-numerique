<?php

namespace App\Entity;

use App\Repository\CertificationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CertificationRepository::class)]
class Certification
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $type = null;

    #[Assert\When(
        expression: 'this.getType() == "RNCP" || this.getType() == "RS" ',
        constraints: [
            new Assert\NotBlank([], message: 'Code obligatoire pour les certifications RNCP ou RS')
        ],
    )]
    #[Assert\When(
        expression: 'this.getType() == "RNCP"',
        constraints: [
            new Assert\Regex('/^RNCP.*/', message: 'Le code doit être de forme RNCPXXXXX')
        ],
    )]
    #[Assert\When(
        expression: 'this.getType() == "RS"',
        constraints: [
            new Assert\Regex('/^RS.*/', message: 'Le code doit être de forme RSXXXX')
        ],
    )]
    #[ORM\Column(length: 100, nullable: true)]
    private ?string $code = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $startDate = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $endDate = null;

    #[ORM\OneToMany(mappedBy: 'certification', targetEntity: PassageCertification::class)]
    private Collection $passageCertifications;

    public function __construct()
    {
        $this->passageCertifications = new ArrayCollection();
    }

    public function __toString(): string
    {
        return $this->name ? $this->name : ($this->code ? $this->code : $this->type);
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

    public function getCode(): ?string
    {
        return $this->code;
    }

    public function setCode(?string $code): static
    {
        $this->code = $code;

        return $this;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(?string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getStartDate(): ?\DateTimeImmutable
    {
        return $this->startDate;
    }

    public function setStartDate(?\DateTimeImmutable $startDate): static
    {
        $this->startDate = $startDate;

        return $this;
    }

    public function getEndDate(): ?\DateTimeImmutable
    {
        return $this->endDate;
    }

    public function setEndDate(?\DateTimeImmutable $endDate): static
    {
        $this->endDate = $endDate;

        return $this;
    }

    /**
     * @return Collection<int, PassageCertification>
     */
    public function getPassageCertifications(): Collection
    {
        return $this->passageCertifications;
    }

    public function addPassageCertification(PassageCertification $passageCertification): static
    {
        if (!$this->passageCertifications->contains($passageCertification)) {
            $this->passageCertifications->add($passageCertification);
            $passageCertification->setCertification($this);
        }

        return $this;
    }

    public function removePassageCertification(PassageCertification $passageCertification): static
    {
        if ($this->passageCertifications->removeElement($passageCertification)) {
            // set the owning side to null (unless already changed)
            if ($passageCertification->getCertification() === $this) {
                $passageCertification->setCertification(null);
            }
        }

        return $this;
    }
}
