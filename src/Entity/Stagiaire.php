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

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateNaissance = null;

    #[Assert\Choice(['M', 'F'])]
    #[ORM\Column(length: 1)]
    private ?string $sexe = null;

    #[ORM\Column(nullable: true)]
    private ?string $codePostalNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $idDossierCpf = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $email = null;

    #[ORM\Column(length: 24, nullable: true)]
    private ?string $phone = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $identifiantsFinanceurs = null;

    #[ORM\Column(nullable: true)]
    private ?bool $visio = null;

    #[Assert\Choice(['Associé', 'Indépendant'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    #[ORM\OneToMany(mappedBy: 'stagiaire', targetEntity: PassageCertification::class)]
    private Collection $passageCertifications;

    #[ORM\OneToMany(mappedBy: 'stagiaire', targetEntity: PresenceWeb::class, orphanRemoval: true)]
    private Collection $presenceWebs;

    #[ORM\ManyToOne(inversedBy: 'stagiairesAdressePostal', cascade: ['persist'])]
    private ?Localisation $adressePostal = null;

    #[ORM\ManyToMany(targetEntity: Localisation::class, inversedBy: 'stagiairesActivite', cascade: ['persist'])]
    private Collection $lieuxActivite;

    public function __construct()
    {
        $this->passageCertifications = new ArrayCollection();
        $this->presenceWebs = new ArrayCollection();
        $this->lieuxActivite = new ArrayCollection();
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

    public function getCodePostalNaissance(): ?string
    {
        return $this->codePostalNaissance;
    }

    public function setCodePostalNaissance(?string $codePostalNaissance): static
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

    public function getPhone(): ?string
    {
        return $this->phone;
    }

    public function setPhone(?string $phone): static
    {
        $this->phone = $phone;

        return $this;
    }

    public function getIdentifiantsFinanceurs(): ?string
    {
        return $this->identifiantsFinanceurs;
    }

    public function setIdentifiantsFinanceurs(?string $identifiantsFinanceurs): static
    {
        $this->identifiantsFinanceurs = $identifiantsFinanceurs;

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


    /**
     * @return Collection<int, PresenceWeb>
     */
    public function getPresenceWebs(): Collection
    {
        return $this->presenceWebs;
    }

    public function addPresenceWeb(PresenceWeb $presenceWeb): static
    {
        if (!$this->presenceWebs->contains($presenceWeb)) {
            $this->presenceWebs->add($presenceWeb);
            $presenceWeb->setStagiaire($this);
        }

        return $this;
    }

    public function removePresenceWeb(PresenceWeb $presenceWeb): static
    {
        if ($this->presenceWebs->removeElement($presenceWeb)) {
            // set the owning side to null (unless already changed)
            if ($presenceWeb->getStagiaire() === $this) {
                $presenceWeb->setStagiaire(null);
            }
        }

        return $this;
    }

    public function getAdressePostal(): ?Localisation
    {
        return $this->adressePostal;
    }

    public function setAdressePostal(?Localisation $adressePostal): static
    {
        $this->adressePostal = $adressePostal;

        return $this;
    }

    /**
     * @return Collection<int, Localisation>
     */
    public function getLieuxActivite(): Collection
    {
        return $this->lieuxActivite;
    }

    public function addLieuxActivite(Localisation $lieuxActivite): static
    {
        if (!$this->lieuxActivite->contains($lieuxActivite)) {
            $this->lieuxActivite->add($lieuxActivite);
        }

        return $this;
    }

    public function removeLieuxActivite(Localisation $lieuxActivite): static
    {
        $this->lieuxActivite->removeElement($lieuxActivite);

        return $this;
    }
}
