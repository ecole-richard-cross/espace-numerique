<?php

namespace App\Entity;

use App\Repository\PassageCertificationRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Types\UuidType;
use Symfony\Component\Uid\Uuid;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: PassageCertificationRepository::class)]
class PassageCertification
{
    #[ORM\Id]
    #[ORM\Column(type: UuidType::NAME, unique: true)]
    #[ORM\GeneratedValue(strategy: 'CUSTOM')]
    #[ORM\CustomIdGenerator(class: 'doctrine.uuid_generator')]
    private ?Uuid $id;

    #[Assert\Choice(['PAR_ADMISSION', 'PAR_SCORING'])]
    #[ORM\Column(length: 255, options: ["default" => 'PAR_SCORING'])]
    private ?string $obtentionCertification = 'PAR_SCORING';

    #[ORM\Column]
    private ?bool $donneeCertifiee = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE)]
    private ?\DateTimeImmutable $dateDebutValidite = null;

    #[ORM\Column(type: Types::DATE_IMMUTABLE, nullable: true)]
    private ?\DateTimeImmutable $dateFinValidite = null;

    #[ORM\Column(options: ["default" => false])]
    private ?bool $presenceNiveauLangueEuro = false;

    #[ORM\Column(options: ["default" => false])]
    private ?bool $presenceNiveauNumeriqueEuro = false;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $scoring = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $mentionValidee = null;

    #[ORM\ManyToOne(inversedBy: 'passageCertifications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Stagiaire $stagiaire = null;

    #[ORM\ManyToOne(inversedBy: 'passageCertifications')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Certification $certification = null;

    public function __toString(): string
    {
        $s = $this->getStagiaire();
        $c = $this->getCertification();
        #{stagiaire.prenom} #{stagiaire.nomNaissance}, certification #{certif.getName()} (#{certif.getCode()}) obtenue le #{passage.dateDebutValidite|date('d-m-Y')}"
        $noms = $s->getPrenom() . " " . $s->getNomNaissance();
        $cert = $c->getName() . " (" . $c->getCode() . ") obtenue le " . $this->getDateDebutValidite()->format('d M Y');
        return $noms . ", certification " . $cert;
    }

    public function getId(): ?Uuid
    {
        return $this->id;
    }

    public function getObtentionCertification(): ?string
    {
        return $this->obtentionCertification;
    }

    public function setObtentionCertification(string $obtentionCertification): static
    {
        $this->obtentionCertification = $obtentionCertification;

        return $this;
    }

    public function isDonneeCertifiee(): ?bool
    {
        return $this->donneeCertifiee;
    }
    public function __toStringIsDonneeCertifiee(): string
    {
        return $this->donneeCertifiee ? "true" : "false";
    }

    public function setDonneeCertifiee(bool $donneeCertifiee): static
    {
        $this->donneeCertifiee = $donneeCertifiee;

        return $this;
    }

    public function getDateDebutValidite(): ?\DateTimeImmutable
    {
        return $this->dateDebutValidite;
    }

    public function setDateDebutValidite(\DateTimeImmutable $dateDebutValidite): static
    {
        $this->dateDebutValidite = $dateDebutValidite;

        return $this;
    }

    public function getDateFinValidite(): ?\DateTimeImmutable
    {
        return $this->dateFinValidite;
    }

    public function setDateFinValidite(?\DateTimeImmutable $dateFinValidite): static
    {
        $this->dateFinValidite = $dateFinValidite;

        return $this;
    }

    public function isPresenceNiveauLangueEuro(): ?bool
    {
        return $this->presenceNiveauLangueEuro;
    }

    public function __toStringIsPresenceNiveauLangueEuro(): string
    {
        return $this->presenceNiveauLangueEuro ? "true" : "false";
    }

    public function setPresenceNiveauLangueEuro(bool $presenceNiveauLangueEuro): static
    {
        $this->presenceNiveauLangueEuro = $presenceNiveauLangueEuro;

        return $this;
    }

    public function isPresenceNiveauNumeriqueEuro(): ?bool
    {
        return $this->presenceNiveauNumeriqueEuro;
    }

    public function __toStringIsPresenceNiveauNumeriqueEuro(): string
    {
        return $this->presenceNiveauNumeriqueEuro ? "true" : "false";
    }

    public function setPresenceNiveauNumeriqueEuro(bool $presenceNiveauNumeriqueEuro): static
    {
        $this->presenceNiveauNumeriqueEuro = $presenceNiveauNumeriqueEuro;

        return $this;
    }

    public function getScoring(): ?string
    {
        return $this->scoring;
    }

    public function setScoring(?string $scoring): static
    {
        $this->scoring = $scoring;

        return $this;
    }

    public function getMentionValidee(): ?string
    {
        return $this->mentionValidee;
    }

    public function setMentionValidee(?string $mentionValidee): static
    {
        $this->mentionValidee = $mentionValidee;

        return $this;
    }

    public function getStagiaire(): ?Stagiaire
    {
        return $this->stagiaire;
    }

    public function setStagiaire(?Stagiaire $stagiaire): static
    {
        $this->stagiaire = $stagiaire;

        return $this;
    }

    public function getCertification(): ?Certification
    {
        return $this->certification;
    }

    public function setCertification(?Certification $certification): static
    {
        $this->certification = $certification;

        return $this;
    }
}
