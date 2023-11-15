<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    #[ORM\Column]
    private array $roles = [];

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    #[ORM\Column(length: 255)]
    private ?string $nomNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomUsage = null;

    #[ORM\Column(length: 255)]
    private ?string $prenom = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomStructure = null;

    #[ORM\Column(nullable: true)]
    private ?\DateTimeImmutable $dateNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $phoneNumber = null;

    #[ORM\Column(nullable: true)]
    private ?bool $visio = null;

    #[Assert\Choice(['Associé', 'Indépendant'])]
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $statut = null;

    #[ORM\OneToOne(inversedBy: 'adressePostaleOfUser', cascade: ['persist', 'remove'])]
    private ?Localisation $adressePostale = null;

    #[ORM\OneToMany(mappedBy: 'lieuxActiviteOfUser', targetEntity: Localisation::class)]
    private Collection $lieuxActivite;

    #[ORM\OneToOne(mappedBy: 'User', cascade: ['persist', 'remove'])]
    private ?Stagiaire $stagiaire = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PresenceWeb::class, orphanRemoval: true)]
    private Collection $PresenceWebs;

    public function __construct()
    {
        $this->lieuxActivite = new ArrayCollection();
        $this->PresenceWebs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {
        $roles = $this->roles;
        // guarantee every user at least has ROLE_USER
        $roles[] = 'ROLE_USER';

        return array_unique($roles);
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // If you store any temporary, sensitive data on the user, clear it here
        // $this->plainPassword = null;
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

    public function getNomStructure(): ?string
    {
        return $this->nomStructure;
    }

    public function setNomStructure(?string $nomStructure): static
    {
        $this->nomStructure = $nomStructure;

        return $this;
    }

    public function getDateNaissance(): ?\DateTimeImmutable
    {
        return $this->dateNaissance;
    }

    public function setDateNaissance(?\DateTimeImmutable $dateNaissance): static
    {
        $this->dateNaissance = $dateNaissance;

        return $this;
    }

    public function getPhoneNumber(): ?string
    {
        return $this->phoneNumber;
    }

    public function setPhoneNumber(?string $phoneNumber): static
    {
        $this->phoneNumber = $phoneNumber;

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

    public function getAdressePostale(): ?Localisation
    {
        return $this->adressePostale;
    }

    public function setAdressePostale(?Localisation $adressePostale): static
    {
        $this->adressePostale = $adressePostale;

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
            $lieuxActivite->setLieuxActiviteOfUser($this);
        }

        return $this;
    }

    public function removeLieuxActivite(Localisation $lieuxActivite): static
    {
        if ($this->lieuxActivite->removeElement($lieuxActivite)) {
            // set the owning side to null (unless already changed)
            if ($lieuxActivite->getLieuxActiviteOfUser() === $this) {
                $lieuxActivite->setLieuxActiviteOfUser(null);
            }
        }

        return $this;
    }

    public function getStagiaire(): ?Stagiaire
    {
        return $this->stagiaire;
    }

    public function setStagiaire(Stagiaire $stagiaire): static
    {
        // set the owning side of the relation if necessary
        if ($stagiaire->getUser() !== $this) {
            $stagiaire->setUser($this);
        }

        $this->stagiaire = $stagiaire;

        return $this;
    }

    /**
     * @return Collection<int, PresenceWeb>
     */
    public function getPresenceWebs(): Collection
    {
        return $this->PresenceWebs;
    }

    public function addPresenceWeb(PresenceWeb $presenceWeb): static
    {
        if (!$this->PresenceWebs->contains($presenceWeb)) {
            $this->PresenceWebs->add($presenceWeb);
            $presenceWeb->setUser($this);
        }

        return $this;
    }

    public function removePresenceWeb(PresenceWeb $presenceWeb): static
    {
        if ($this->PresenceWebs->removeElement($presenceWeb)) {
            // set the owning side to null (unless already changed)
            if ($presenceWeb->getUser() === $this) {
                $presenceWeb->setUser(null);
            }
        }

        return $this;
    }
}
