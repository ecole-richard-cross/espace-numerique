<?php

namespace App\Entity;

use App\Repository\TagRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagRepository::class)]
class Tag
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Seminar::class, mappedBy: 'tags')]
    private Collection $seminars;

    #[ORM\ManyToMany(targetEntity: Discussion::class, mappedBy: 'tags')]
    private Collection $discussions;

    public function __construct()
    {
        $this->seminars = new ArrayCollection();
        $this->discussions = new ArrayCollection();
    }

    function __toString(): string
    {
        return $this->name;
    }

    public function getId(): ?int
    {
        return $this->id;
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
            $seminar->addTag($this);
        }

        return $this;
    }

    public function removeSeminar(Seminar $seminar): static
    {
        if ($this->seminars->removeElement($seminar)) {
            $seminar->removeTag($this);
        }

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
            $discussion->addTag($this);
        }

        return $this;
    }

    public function removeDiscussion(Discussion $discussion): static
    {
        if ($this->discussions->removeElement($discussion)) {
            $discussion->removeTag($this);
        }

        return $this;
    }
}
