<?php

namespace App\Entity;

use App\Repository\LocalisationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use PostalCodeTools;

#[ORM\Entity(repositoryClass: LocalisationRepository::class)]
class Localisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[ORM\Column(nullable: true)]
    private ?string $codePostal = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $departement = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $region = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $ville = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $pays = null;

    #[ORM\OneToMany(mappedBy: 'localisation', targetEntity: CentreFormation::class)]
    private Collection $centreFormations;

    #[ORM\OneToOne(mappedBy: 'adressePostale', cascade: ['persist', 'remove'])]
    private ?User $AdressePostaleOfUser = null;

    #[ORM\ManyToOne(inversedBy: 'lieuxActivite')]
    private ?User $LieuActiviteOfUser = null;

    public function __construct()
    {
        $this->centreFormations = new ArrayCollection();
    }

    public function __toString()
    {
        if (isset($this->adresse) && isset($this->codePostal) && isset($this->ville)) {
            return $this->adresse . ' ' . $this->codePostal . ' ' . $this->ville;
        } else if (isset($this->ville) && isset($this->pays)) {
            return  $this->ville . ' (' . $this->pays . ')';
        } else {
            return $this->codePostal ? $this->codePostal : ($this->ville ? $this->ville : ($this->pays ? $this->pays : 'Localisation vide'));
        }
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(?string $adresse): static
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->codePostal;
    }

    public function setCodePostal(?string $codePostal): static
    {
        $this->codePostal = $codePostal;

        return $this;
    }
    public function fetchFromCodePostal(): static
    {
        if (trim(strtolower($this->getPays())) !== "france")
            return $this;

        $details = PostalCodeTools::fetchDetails($this->getCodePostal());
        $this->setDepartement($details['department']);
        $this->setRegion($details['region']);

        return $this;
    }
    public function getDepartement(): ?string
    {
        return $this->departement;
    }

    private function setDepartement(?string $departement): static
    {
        $this->departement = $departement;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->region;
    }

    private function setRegion(?string $region): static
    {
        $this->region = $region;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(?string $ville): static
    {
        $this->ville = $ville;

        return $this;
    }

    public function getPays(): ?string
    {
        return $this->pays;
    }

    public function setPays(?string $pays): static
    {
        $this->pays = $pays;

        return $this;
    }

    /**
     * @return Collection<int, CentreFormation>
     */
    public function getCentreFormations(): Collection
    {
        return $this->centreFormations;
    }

    public function addCentreFormation(CentreFormation $centreFormation): static
    {
        if (!$this->centreFormations->contains($centreFormation)) {
            $this->centreFormations->add($centreFormation);
            $centreFormation->setLocalisation($this);
        }

        return $this;
    }

    public function removeCentreFormation(CentreFormation $centreFormation): static
    {
        if ($this->centreFormations->removeElement($centreFormation)) {
            // set the owning side to null (unless already changed)
            if ($centreFormation->getLocalisation() === $this) {
                $centreFormation->setLocalisation(null);
            }
        }

        return $this;
    }

    public function getAdressePostaleOfUser(): ?User
    {
        return $this->AdressePostaleOfUser;
    }

    public function setAdressePostaleOfUser(?User $AdressePostaleOfUser): static
    {
        // unset the owning side of the relation if necessary
        if ($AdressePostaleOfUser === null && $this->AdressePostaleOfUser !== null) {
            $this->AdressePostaleOfUser->setAdressePostale(null);
        }

        // set the owning side of the relation if necessary
        if ($AdressePostaleOfUser !== null && $AdressePostaleOfUser->getAdressePostale() !== $this) {
            $AdressePostaleOfUser->setAdressePostale($this);
        }

        $this->AdressePostaleOfUser = $AdressePostaleOfUser;

        return $this;
    }

    public function getLieuActiviteOfUser(): ?User
    {
        return $this->LieuActiviteOfUser;
    }

    public function setLieuActiviteOfUser(?User $LieuActiviteOfUser): static
    {
        $this->LieuActiviteOfUser = $LieuActiviteOfUser;

        return $this;
    }
}
