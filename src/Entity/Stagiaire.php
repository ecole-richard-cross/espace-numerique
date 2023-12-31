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

    #[Assert\Choice(['M', 'F'])]
    #[ORM\Column(length: 1)]
    private ?string $sexe = null;

    #[ORM\Column(length: 9, nullable: true)]
    private ?string $codePostalNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $idDossierCpf = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $identifiantsFinanceurs = null;

    #[ORM\OneToMany(mappedBy: 'stagiaire', targetEntity: PassageCertification::class, cascade: ['persist'])]
    private Collection $passageCertifications;

    #[ORM\Column]
    private ?bool $enFormation = null;

    #[ORM\ManyToMany(targetEntity: Promotion::class, inversedBy: 'stagiaires')]
    private Collection $Promotion;

    #[ORM\OneToOne(inversedBy: 'stagiaire', cascade: ['persist'])]
    #[ORM\JoinColumn(nullable: true, onDelete: 'SET NULL')]
    private ?User $User = null;

    public function __construct()
    {
        $this->passageCertifications = new ArrayCollection();
        $this->Promotion = new ArrayCollection();
    }

    public  function __toString(): string
    {
        return $this->getUser()->__toString();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getIdentifiantsFinanceurs(): ?string
    {
        return $this->identifiantsFinanceurs;
    }

    public function setIdentifiantsFinanceurs(?string $identifiantsFinanceurs): static
    {
        $this->identifiantsFinanceurs = $identifiantsFinanceurs;

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

    public function isEnFormation(): ?bool
    {
        return $this->enFormation;
    }

    public function setEnFormation(bool $enFormation): static
    {
        $this->enFormation = $enFormation;

        return $this;
    }

    /**
     * @return Collection<int, Promotion>
     */
    public function getPromotion(): Collection
    {
        return $this->Promotion;
    }

    public function addPromotion(Promotion $promotion): static
    {
        if (!$this->Promotion->contains($promotion)) {
            $this->Promotion->add($promotion);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): static
    {
        $this->Promotion->removeElement($promotion);

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->User;
    }

    public function setUser(User $User): static
    {
        $this->User = $User;

        return $this;
    }
}
