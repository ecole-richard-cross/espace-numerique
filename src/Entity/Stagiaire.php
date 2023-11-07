<?php

namespace App\Entity;

use App\Repository\StagiaireRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;


#[ORM\Entity(repositoryClass: StagiaireRepository::class)]
class Stagiaire
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 60)]
    private ?string $nomNaissance = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $nomUsage = null;

    #[ORM\Column(length: 60)]
    private ?string $prenom = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $prenom2 = null;

    #[ORM\Column(length: 60, nullable: true)]
    private ?string $prenom3 = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateNaissance = null;

    #[Assert\Choice(['M', 'F'])]
    #[ORM\Column(length: 1)]
    private ?string $sexe = null;

    #[ORM\Column(nullable: true)]
    private ?int $codePostalNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $idDossierCpf = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $siteWeb = null;

    #[ORM\Column(nullable: true)]
    private ?array $reseaux = null;

    #[ORM\Column(nullable: true)]
    private ?array $localisation = null;

    #[ORM\Column(nullable: true)]
    private ?bool $visio = null;

    #[Assert\Choice(['Associé', 'Indépendant'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    #[ORM\OneToMany(mappedBy: 'stagiaireId', targetEntity: PassageCertification::class)]
    private Collection $passageCertifications;

    public function __construct()
    {
        $this->passageCertifications = new ArrayCollection();
    }

    public  function __toString(): string
    {
        return $this->prenom . " " . $this->nomNaissance;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomNaissance(): ?string
    {
        return $this->nomNaissance;
    }

    public function setNomNaissance(string $nomNaissance): static
    {
        $this->nomNaissance = $nomNaissance;

        return $this;
    }

    public function getNomUsage(): ?string
    {
        return $this->nomUsage;
    }

    public function setNomUsage(?string $nomUsage): static
    {
        $this->nomUsage = $nomUsage;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): static
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getPrenom2(): ?string
    {
        return $this->prenom2;
    }

    public function setPrenom2(?string $prenom2): static
    {
        $this->prenom2 = $prenom2;

        return $this;
    }

    public function getPrenom3(): ?string
    {
        return $this->prenom3;
    }

    public function setPrenom3(?string $prenom3): static
    {
        $this->prenom3 = $prenom3;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeImmutable
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(\DateTimeImmutable $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getSexe(): ?string
    {
        return $this->sexe;
    }

    public function setSexe(string $sexe): static
    {
        $this->sexe = $sexe;

        return $this;
    }

    public function getCodePostalNaissance(): ?int
    {
        return $this->codePostalNaissance;
    }

    public function setCodePostalNaissance(?int $codePostalNaissance): static
    {
        $this->codePostalNaissance = $codePostalNaissance;

        return $this;
    }

    public function getIdDossierCpf(): ?string
    {
        return $this->idDossierCpf;
    }

    public function setIdDossierCpf(?string $idDossierCpf): static
    {
        $this->idDossierCpf = $idDossierCpf;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(?string $email): static
    {
        $this->email = $email;

        return $this;
    }

    public function getSiteWeb(): ?string
    {
        return $this->siteWeb;
    }

    public function setSiteWeb(?string $siteWeb): static
    {
        $this->siteWeb = $siteWeb;

        return $this;
    }

    public function getReseaux(): ?array
    {
        return $this->reseaux;
    }

    public function setReseaux(?array $reseaux): static
    {
        $this->reseaux = $reseaux;

        return $this;
    }

    public function getLocalisation(): ?array
    {
        return $this->localisation;
    }

    public function setLocalisation(?array $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    public function isVisio(): ?bool
    {
        return $this->visio;
    }

    public function setVisio(?bool $visio): static
    {
        $this->visio = $visio;

        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(?string $statut): static
    {
        $this->statut = $statut;

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
            $passageCertification->setStagiaire($this);
        }

        return $this;
    }

    public function removePassageCertification(PassageCertification $passageCertification): static
    {
        if ($this->passageCertifications->removeElement($passageCertification)) {
            // set the owning side to null (unless already changed)
            if ($passageCertification->getStagiaire() === $this) {
                $passageCertification->setStagiaire(null);
            }
        }

        return $this;
    }
}
