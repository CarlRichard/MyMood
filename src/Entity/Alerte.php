<?php

namespace App\Entity;

use App\Repository\AlerteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: AlerteRepository::class)]
#[ApiResource]
class Alerte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    private ?\DateTimeInterface $dateEnvoi = null;

    #[ORM\Column]
    private ?int $statut = null;

    #[ORM\OneToMany(targetEntity: Historique::class, mappedBy: 'alerte', cascade: ['persist', 'remove'])]
    private Collection $historiques;

    public function __construct()
    {
        $this->historiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->dateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $DateEnvoi): static
    {
        $this->DateEnvoi = $DateEnvoi;
        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->statut;
    }

    public function setStatut(int $Statut): static
    {
        $this->Statut = $Statut;
        return $this;
    }

    public function getHistoriques(): Collection
    {
        return $this->historiques;
    }

    public function addHistorique(Historique $historique): static
    {
        if (!$this->historiques->contains($historique)) {
            $this->historiques->add($historique);
            $historique->setAlerte($this);
        }

        return $this;
    }

    public function removeHistorique(Historique $historique): static
    {
        if ($this->historiques->removeElement($historique)) {
            if ($historique->getAlerte() === $this) {
                $historique->setAlerte(null);
            }
        }

        return $this;
    }
}
