<?php

namespace App\Entity;

use App\Repository\LocalisationRepository;
use App\Service\PostalCodeTools;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;
use Exception;

#[ORM\Entity(repositoryClass: LocalisationRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Localisation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $adresse = null;

    #[Assert\When(
        expression: 'this.getPays() == "france" || this.getPays() == "France" || this.getPays() == null',
        constraints: [
            new Assert\Regex(pattern: '/^(?:0[1-9]|[1-8]\d|9[0-8])\d{3}$/', message: 'Code postal invalide')
        ],
    )]
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

    #[ORM\OneToOne(mappedBy: 'localisation', targetEntity: CentreFormation::class)]
    private CentreFormation $centreFormation;

    #[ORM\OneToOne(mappedBy: 'adressePostale', cascade: ['persist', 'remove'])]
    private ?User $adressePostaleOfUser = null;

    #[ORM\ManyToOne(inversedBy: 'lieuxActivite')]
    private ?User $lieuxActiviteOfUser = null;

    public function __toString()
    {
        if (isset($this->adresse))
            $address = $this->adresse . ",";
        else
            $address = "";

        if (isset($this->codePostal) && $this->codePostal != "n/a")
            $cp = $this->codePostal;
        else
            $cp = "";

        if (isset($this->ville))
            $ville = $this->ville;
        else
            $ville = "";

        if (isset($this->departement, $this->region)) {
            $pays = "France";
            $depreg = "(" . $this->departement . ", " . $this->region . ")";
        } else {
            $pays = $this->pays ?? "";
            $depreg = "";
        }

        return $address . " " . $cp . " " . $ville . " " . $depreg . " " . $pays;
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

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function fetchFromCodePostal(): static
    {
        if (
            (trim(strtolower($this->pays)) !== "france" &&
                trim($this->pays) !== "" &&
                $this->pays !== null) ||
            !preg_match("/^\d{5}$/", trim($this->codePostal))
        ) {
            $this->setDepartement(null);
            $this->setRegion(null);
            return $this;
        }

        try {
            $details = PostalCodeTools::fetchDetails($this->codePostal);
            $this->setDepartement($details['department']);
            $this->setRegion($details['region']);
        } catch (Exception $e) {
            $this->setDepartement('dpt');
            $this->setRegion("reg");
        }

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

    public function getCentreFormation(): CentreFormation
    {
        return $this->centreFormation;
    }

    public function setCentreFormation(CentreFormation $centreFormation): static
    {
        $this->centreFormation = $centreFormation;
        return $this;
    }

    public function getAdressePostaleOfUser(): ?User
    {
        return $this->adressePostaleOfUser;
    }

    public function setAdressePostaleOfUser(?User $adressePostaleOfUser): static
    {
        // unset the owning side of the relation if necessary
        if ($adressePostaleOfUser === null && $this->adressePostaleOfUser !== null) {
            $this->adressePostaleOfUser->setAdressePostale(null);
        }

        // set the owning side of the relation if necessary
        if ($adressePostaleOfUser !== null && $adressePostaleOfUser->getAdressePostale() !== $this) {
            $adressePostaleOfUser->setAdressePostale($this);
        }

        $this->adressePostaleOfUser = $adressePostaleOfUser;

        return $this;
    }

    public function getLieuxActiviteOfUser(): ?User
    {
        return $this->lieuxActiviteOfUser;
    }

    public function setLieuxActiviteOfUser(?User $lieuxActiviteOfUser): static
    {
        $this->lieuxActiviteOfUser = $lieuxActiviteOfUser;

        return $this;
    }

    #[Assert\IsTrue(message: 'Une addresse en France doit comporter au moins un code postal. Une adresse à l\'étranger, une ville et un pays.')]
    public function hasMinimumInfo(): bool
    {
        return isset($this->codePostal) || (isset($this->ville) && isset($this->pays) && trim(strtolower($this->pays)) != "france");
    }
}
