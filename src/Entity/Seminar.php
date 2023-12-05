<?php

namespace App\Entity;

use App\Repository\SeminarRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\HasLifecycleCallbacks]
#[ORM\Entity(repositoryClass: SeminarRepository::class)]
class Seminar
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $title = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $description = null;

    #[ORM\Column]
    private ?bool $isPublished = null;

    #[ORM\Column]
    private array $roles = [];

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $updatedAt = null;

    #[ORM\OneToMany(mappedBy: 'seminar', targetEntity: Chapter::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $chapters;

    #[ORM\OneToMany(mappedBy: 'seminar', targetEntity: SeminarConsultation::class, orphanRemoval: true, cascade: ['persist', 'remove'])]
    private Collection $seminarConsultations;

    #[ORM\ManyToOne(inversedBy: 'seminars', cascade: ['persist'])]
    private ?Media $image = null;

    #[ORM\ManyToMany(targetEntity: Category::class, inversedBy: 'seminars')]
    private Collection $categories;

    #[ORM\ManyToMany(targetEntity: Tag::class, inversedBy: 'seminars')]
    private Collection $tags;

    public function __construct()
    {
        $this->chapters = new ArrayCollection();
        $this->seminarConsultations = new ArrayCollection();
        $this->categories = new ArrayCollection();
        $this->tags = new ArrayCollection();
    }

    public function __toString()
    {
        return $this->title;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): static
    {
        $this->title = $title;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): static
    {
        $this->description = $description;

        return $this;
    }

    public function isIsPublished(): ?bool
    {
        return $this->isPublished;
    }

    public function setIsPublished(bool $isPublished): static
    {
        $this->isPublished = $isPublished;

        return $this;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    #[ORM\PrePersist]
    public function setCreatedAt(): static
    {
        $this->createdAt = new \DateTimeImmutable();

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
        $this->updatedAt = new \DateTimeImmutable();

        return $this;
    }

    /**
     * @return Collection<int, Chapter>
     */
    public function getChapters(): Collection
    {
        return $this->chapters;
    }

    public function addChapter(Chapter $chapter): static
    {
        if (!$this->chapters->contains($chapter)) {
            $this->chapters->add($chapter);
            $chapter->setSeminar($this);
        }

        return $this;
    }

    public function removeChapter(Chapter $chapter): static
    {
        if ($this->chapters->removeElement($chapter)) {
            // set the owning side to null (unless already changed)
            if ($chapter->getSeminar() === $this) {
                $chapter->setSeminar(null);
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

    public function getConsultByUser(User $user): ?SeminarConsultation
    {
        $result = null;
        foreach ($this->seminarConsultations as $consult) {
            if ($consult->getUser() == $user)
                $result = $consult;
        }
        return $result;
    }

    public function addSeminarConsultation(SeminarConsultation $seminarConsultation): static
    {
        if (!$this->seminarConsultations->contains($seminarConsultation)) {
            $this->seminarConsultations->add($seminarConsultation);
            $seminarConsultation->setSeminar($this);
        }

        return $this;
    }

    public function removeSeminarConsultation(SeminarConsultation $seminarConsultation): static
    {
        if ($this->seminarConsultations->removeElement($seminarConsultation)) {
            // set the owning side to null (unless already changed)
            if ($seminarConsultation->getSeminar() === $this) {
                $seminarConsultation->setSeminar(null);
            }
        }

        return $this;
    }

    public function getImage(): ?Media
    {
        return $this->image;
    }

    public function setImage(?Media $image): static
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection<int, Category>
     */
    public function getCategories(): Collection
    {
        return $this->categories;
    }

    public function addCategory(Category $category): static
    {
        if (!$this->categories->contains($category)) {
            $this->categories->add($category);
        }

        return $this;
    }

    public function removeCategory(Category $category): static
    {
        $this->categories->removeElement($category);

        return $this;
    }

    /**
     * @return Collection<int, Tag>
     */
    public function getTags(): Collection
    {
        return $this->tags;
    }

    public function addTag(Tag $tag): static
    {
        if (!$this->tags->contains($tag)) {
            $this->tags->add($tag);
        }

        return $this;
    }

    public function removeTag(Tag $tag): static
    {
        $this->tags->removeElement($tag);

        return $this;
    }
}
