<?php

namespace App\Entity;

use App\Repository\UserRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: UserRepository::class)]
#[UniqueEntity(fields: ['email'], message: 'Cet email est déjà utilisé.')]
class User implements UserInterface, PasswordAuthenticatedUserInterface
{
    const ROLES = [
        'Admin' => 'ROLE_ADMIN',
        'Formateur ERC' => 'ROLE_FORMATEUR_ERC',
        'Formateur Externe' => 'ROLE_FORMATEUR_EXT',
        'Stagiaire en formation' => 'ROLE_STAGIAIRE',
        'Stagiaire formé' => 'ROLE_EX_STAGIAIRE',
        'Utilisateur public' => 'ROLE_USER'
    ];
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

    #[Assert\NotBlank]
    #[ORM\Column(length: 255)]
    private ?string $nomNaissance = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $nomUsage = null;

    #[Assert\NotBlank]
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

    #[Assert\Valid]
    #[ORM\OneToOne(inversedBy: 'adressePostaleOfUser', cascade: ['persist', 'remove'])]
    private ?Localisation $adressePostale = null;

    #[Assert\Valid]
    #[ORM\OneToMany(mappedBy: 'lieuxActiviteOfUser', targetEntity: Localisation::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $lieuxActivite;

    #[ORM\OneToOne(mappedBy: 'User', cascade: ['persist', 'remove'])]
    private ?Stagiaire $stagiaire = null;

    #[Assert\Valid]
    #[ORM\OneToMany(mappedBy: 'user', targetEntity: PresenceWeb::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $presenceWebs;

    #[ORM\OneToMany(mappedBy: 'uploadedBy', targetEntity: Media::class)]
    private Collection $media;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: SeminarConsultation::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $seminarConsultations;

    #[ORM\ManyToOne(inversedBy: 'users', cascade: ['persist', 'remove'])]
    private ?Media $avatar = null;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Discussion::class, orphanRemoval: false)]
    private Collection $discussions;

    #[ORM\OneToMany(mappedBy: 'user', targetEntity: Comment::class, orphanRemoval: false)]
    private Collection $comments;

    #[ORM\Column(type: 'boolean')]
    private $isVerified = false;

    public function __construct()
    {
        $this->lieuxActivite = new ArrayCollection();
        $this->presenceWebs = new ArrayCollection();
        $this->media = new ArrayCollection();
        $this->seminarConsultations = new ArrayCollection();
        $this->discussions = new ArrayCollection();
        $this->comments = new ArrayCollection();
    }


    public  function __toString(): string
    {
        return $this->getPrenom() . " " . ($this->getNomUsage() != null ? $this->getNomUsage() : $this->getNomNaissance());
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

    public function setNomNaissance(?string $nomNaissance): static
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

    public function setPrenom(?string $prenom): static
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
        return $this->presenceWebs;
    }

    public function addPresenceWeb(PresenceWeb $presenceWeb): static
    {
        if (!$this->presenceWebs->contains($presenceWeb)) {
            $this->presenceWebs->add($presenceWeb);
            $presenceWeb->setUser($this);
        }

        return $this;
    }

    public function removePresenceWeb(PresenceWeb $presenceWeb): static
    {
        if ($this->presenceWebs->removeElement($presenceWeb)) {
            // set the owning side to null (unless already changed)
            if ($presenceWeb->getUser() === $this) {
                $presenceWeb->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Media>
     */
    public function getMedia(): Collection
    {
        return $this->media;
    }

    public function addMedium(Media $medium): static
    {
        if (!$this->media->contains($medium)) {
            $this->media->add($medium);
            $medium->setUploadedBy($this);
        }

        return $this;
    }

    public function removeMedium(Media $medium): static
    {
        if ($this->media->removeElement($medium)) {
            // set the owning side to null (unless already changed)
            if ($medium->getUploadedBy() === $this) {
                $medium->setUploadedBy(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, SeminarConsultation>
     */
    public function getSeminarConsultations(): Collection
    {
        return $this->seminarConsultations;
    }

    public function addSeminarConsultation(SeminarConsultation $seminarConsultation): static
    {
        if (!$this->seminarConsultations->contains($seminarConsultation)) {
            $this->seminarConsultations->add($seminarConsultation);
            $seminarConsultation->setUser($this);
        }

        return $this;
    }

    public function removeSeminarConsultation(SeminarConsultation $seminarConsultation): static
    {
        if ($this->seminarConsultations->removeElement($seminarConsultation)) {
            // set the owning side to null (unless already changed)
            if ($seminarConsultation->getUser() === $this) {
                $seminarConsultation->setUser(null);
            }
        }

        return $this;
    }

    public function getAvatar(): ?Media
    {
        return $this->avatar;
    }

    public function setAvatar(?Media $avatar): static
    {
        $this->avatar = $avatar;

        return $this;
    }

    /**
     * @return Collection<int, Discussion>
     */
    public function getDiscussions(): Collection
    {
        return $this->discussions;
    }

    public function addDiscussion(Discussion $discussion): static
    {
        if (!$this->discussions->contains($discussion)) {
            $this->discussions->add($discussion);
            $discussion->setUser($this);
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): static
    {
        if ($this->discussions->removeElement($discussion)) {
            // set the owning side to null (unless already changed)
            if ($discussion->getUser() === $this) {
                $discussion->setUser(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Comment>
     */
    public function getComments(): Collection
    {
        return $this->comments;
    }

    public function addComment(Comment $comment): static
    {
        if (!$this->comments->contains($comment)) {
            $this->comments->add($comment);
            $comment->setUser($this);
        }

        return $this;
    }

    public function removeComment(Comment $comment): static
    {
        if ($this->comments->removeElement($comment)) {
            // set the owning side to null (unless already changed)
            if ($comment->getUser() === $this) {
                $comment->setUser(null);
            }
        }

        return $this;
    }

    public function isVerified(): bool
    {
        return $this->isVerified;
    }

    public function setIsVerified(bool $isVerified): static
    {
        $this->isVerified = $isVerified;

        return $this;
    }
}
