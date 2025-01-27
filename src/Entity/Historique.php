<?php
namespace App\Entity;

use App\Repository\HistoriqueRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Doctrine\DBAL\Types\Types;

#[ORM\Entity(repositoryClass: HistoriqueRepository::class)]
#[ApiResource]
class Historique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $dateCreation  = null;

    #[ORM\Column(nullable: true)]
    private ?int $humeur = null;

    #[ORM\ManyToOne(targetEntity: Utilisateur::class, inversedBy: 'historiques')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Utilisateur $utilisateur = null;

    #[ORM\ManyToOne(targetEntity: Alerte::class, inversedBy: 'historiques')]
    private ?Alerte $alerte = null;

    // Propriétés pour l'action et la date de l'action
    #[ORM\Column(length: 255, nullable: true)]
    private ?string $action = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: true)]
    private ?\DateTimeInterface $dateAction = null;

    // Getters et setters pour id, dateCreation , humeur, utilisateur et alerte

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation (): ?\DateTimeInterface
    {
        return $this->dateCreation ;
    }

    public function setDateCreation (\DateTimeInterface $dateCreation ): static
    {
        $this->dateCreation  = $dateCreation ;
        return $this;
    }

    public function getHumeur(): ?int
    {
        return $this->humeur;
    }

    public function setHumeur(?int $Humeur): static
    {
        $this->humeur = $Humeur;
        return $this;
    }

    public function getUtilisateur(): ?Utilisateur
    {
        return $this->utilisateur;
    }

    public function setUtilisateur(?Utilisateur $utilisateur): static
    {
        $this->utilisateur = $utilisateur;
        return $this;
    }

    public function getAlerte(): ?Alerte
    {
        return $this->alerte;
    }

    public function setAlerte(?Alerte $alerte): static
    {
        $this->alerte = $alerte;
        return $this;
    }

    // Getter et setter pour l'action
    public function getAction(): ?string
    {
        return $this->action;
    }

    public function setAction(?string $action): static
    {
        $this->action = $action;
        return $this;
    }

    // Getter et setter pour la date de l'action
    public function getDateAction(): ?\DateTimeInterface
    {
        return $this->dateAction;
    }

    public function setDateAction(?\DateTimeInterface $dateAction): static
    {
        $this->dateAction = $dateAction;
        return $this;
    }
}