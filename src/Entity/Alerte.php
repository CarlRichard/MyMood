<?php

namespace App\Entity;

use App\Repository\AlerteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
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

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $DateEnvoi = null;

    #[ORM\Column]
    private ?int $Statut = null;

    /**
     * @var Collection<int, Historique>
     */
    #[ORM\OneToMany(targetEntity: Historique::class, mappedBy: 'alerte')]
    private Collection $historique;

    /**
     * @var Collection<int, Utilisateur>
     */
    #[ORM\OneToMany(targetEntity: Utilisateur::class, mappedBy: 'alerte')]
    private Collection $utilisateurs;

    public function __construct()
    {
        $this->historique = new ArrayCollection();
        $this->utilisateurs = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateEnvoi(): ?\DateTimeInterface
    {
        return $this->DateEnvoi;
    }

    public function setDateEnvoi(\DateTimeInterface $DateEnvoi): static
    {
        $this->DateEnvoi = $DateEnvoi;

        return $this;
    }

    public function getStatut(): ?int
    {
        return $this->Statut;
    }

    public function setStatut(int $Statut): static
    {
        $this->Statut = $Statut;

        return $this;
    }

    /**
     * @return Collection<int, Historique>
     */
    public function getHistorique(): Collection
    {
        return $this->historique;
    }

    public function addHistorique(Historique $historique): static
    {
        if (!$this->historique->contains($historique)) {
            $this->historique->add($historique);
            $historique->setAlerte($this);
        }

        return $this;
    }

    public function removeHistorique(Historique $historique): static
    {
        if ($this->historique->removeElement($historique)) {
            // set the owning side to null (unless already changed)
            if ($historique->getAlerte() === $this) {
                $historique->setAlerte(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Utilisateur>
     */
    public function getUtilisateurs(): Collection
    {
        return $this->utilisateurs;
    }

    public function addUtilisateur(Utilisateur $utilisateur): static
    {
        if (!$this->utilisateurs->contains($utilisateur)) {
            $this->utilisateurs->add($utilisateur);
            $utilisateur->setAlerte($this);
        }

        return $this;
    }

    public function removeUtilisateur(Utilisateur $utilisateur): static
    {
        if ($this->utilisateurs->removeElement($utilisateur)) {
            // set the owning side to null (unless already changed)
            if ($utilisateur->getAlerte() === $this) {
                $utilisateur->setAlerte(null);
            }
        }

        return $this;
    }
}
