<?php

namespace App\Entity;

use App\Repository\CentreFormationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CentreFormationRepository::class)]
class CentreFormation
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $debutActivite = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $finActivite = null;

    #[ORM\ManyToOne(inversedBy: 'centreFormations')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Localisation $localisation = null;

    #[ORM\OneToMany(mappedBy: 'centreFormation', targetEntity: Promotion::class)]
    private Collection $promotions;

    public function __construct()
    {
        $this->promotions = new ArrayCollection();
    }

    public function __toString()
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

    public function getDebutActivite(): ?\DateTimeImmutable
    {
        return $this->debutActivite;
    }

    public function setDebutActivite(?\DateTimeImmutable $debutActivite): static
    {
        $this->debutActivite = $debutActivite;

        return $this;
    }

    public function getFinActivite(): ?\DateTimeImmutable
    {
        return $this->finActivite;
    }

    public function setFinActivite(?\DateTimeImmutable $finActivite): static
    {
        $this->finActivite = $finActivite;

        return $this;
    }

    public function getLocalisation(): ?Localisation
    {
        return $this->localisation;
    }

    public function setLocalisation(?Localisation $localisation): static
    {
        $this->localisation = $localisation;

        return $this;
    }

    /**
     * @return Collection<int, Promotion>
     */
    public function getPromotions(): Collection
    {
        return $this->promotions;
    }

    public function addPromotion(Promotion $promotion): static
    {
        if (!$this->promotions->contains($promotion)) {
            $this->promotions->add($promotion);
            $promotion->setCentreFormation($this);
        }

        return $this;
    }

    public function removePromotion(Promotion $promotion): static
    {
        if ($this->promotions->removeElement($promotion)) {
            // set the owning side to null (unless already changed)
            if ($promotion->getCentreFormation() === $this) {
                $promotion->setCentreFormation(null);
            }
        }

        return $this;
    }
}
