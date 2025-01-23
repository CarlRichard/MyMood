<?php

namespace App\Entity;

use App\Repository\HistoriqueRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: HistoriqueRepository::class)]
#[ApiResource]
class Historique
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $DateEnvoi = null;

    #[ORM\Column]
    private ?int $Humeur = null;

    #[ORM\ManyToOne(inversedBy: 'historique')]
    private ?Alerte $alerte = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEnvoi(): ?string
    {
        return $this->DateEnvoi;
    }

    public function setDateEnvoi(string $DateEnvoi): static
    {
        $this->DateEnvoi = $DateEnvoi;

        return $this;
    }

    public function getHumeur(): ?int
    {
        return $this->Humeur;
    }

    public function setHumeur(int $Humeur): static
    {
        $this->Humeur = $Humeur;

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
}
