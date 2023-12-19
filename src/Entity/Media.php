<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Repository\MediaRepository;
use App\EventListener\MediaFileClear;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: MediaRepository::class)]
#[ORM\EntityListeners([MediaFileClear::class])]
class Media
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    #[Assert\Choice(
        choices: ['image', 'audio', 'video', 'file'],
        message: "Sélectionnez un type valide."
    )]
    private ?string $type = null;

    #[ORM\Column(length: 255)]
    private ?string $url = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\ManyToOne(inversedBy: 'media')]
    #[ORM\JoinColumn(onDelete: "SET NULL")]
    private ?User $uploadedBy = null;

    #[ORM\OneToMany(mappedBy: 'media', targetEntity: Block::class)]
    private Collection $blocks;

    #[ORM\OneToMany(mappedBy: 'avatar', targetEntity: User::class)]
    private Collection $users;

    #[ORM\OneToMany(mappedBy: 'image', targetEntity: Seminar::class)]
    private Collection $seminars;

    public function __construct()
    {
        $this->blocks = new ArrayCollection();
        $this->users = new ArrayCollection();
        $this->seminars = new ArrayCollection();
    }

    public function __toString(): string
    {
        $types = [
            'image' => 'Image',
            'audio' => 'Audio',
            'video' => 'Vidéo',
            'file' => 'Fichier'
        ];
        return ($types[$this->type] ?? "") . " - " . $this->name;
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

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): static
    {
        $this->createdAt = new \DateTimeImmutable();;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updatedAt;
    }

    #[ORM\PrePersist]
    #[ORM\PreUpdate]
    public function setUpdatedAt(): static
    {
        $this->updatedAt = new \DateTimeImmutable();;

        return $this;
    }

    public function getUploadedBy(): ?User
    {
        return $this->uploadedBy;
    }

    public function setUploadedBy(?User $uploadedBy): static
    {
        $this->uploadedBy = $uploadedBy;

        return $this;
    }

    /**
     * @return Collection<int, Block>
     */
    public function getBlocks(): Collection
    {
        return $this->blocks;
    }

    public function addBlock(Block $block): static
    {
        if (!$this->blocks->contains($block)) {
            $this->blocks->add($block);
            $block->setMedia($this);
        }

        return $this;
    }

    public function removeBlock(Block $block): static
    {
        if ($this->blocks->removeElement($block)) {
            // set the owning side to null (unless already changed)
            if ($block->getMedia() === $this) {
                $block->setMedia(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, User>
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    public function addUser(User $user): static
    {
        if (!$this->users->contains($user)) {
            $this->users->add($user);
            $user->setAvatar($this);
        }

        return $this;
    }

    public function removeUser(User $user): static
    {
        if ($this->users->removeElement($user)) {
            // set the owning side to null (unless already changed)
            if ($user->getAvatar() === $this) {
                $user->setAvatar(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Seminar>
     */
    public function getSeminars(): Collection
    {
        return $this->seminars;
    }

    public function addSeminar(Seminar $seminar): static
    {
        if (!$this->seminars->contains($seminar)) {
            $this->seminars->add($seminar);
            $seminar->setImage($this);
        }

        return $this;
    }

    public function removeSeminar(Seminar $seminar): static
    {
        if ($this->seminars->removeElement($seminar)) {
            // set the owning side to null (unless already changed)
            if ($seminar->getImage() === $this) {
                $seminar->setImage(null);
            }
        }

        return $this;
    }

    /**
     * Returns all instances linked to this media
     *
     * @return array<Collection>
     */
    public function getUses(): array
    {
        $uses = [
            'blocks' => $this->getBlocks(),
            'seminars' => $this->getSeminars(),
            'users' => $this->getUsers()
        ];
        return $uses;
    }

    public function getUsesAmount(): int
    {
        return  count($this->getBlocks()) + count($this->getSeminars()) + count($this->getUsers());
    }
}
