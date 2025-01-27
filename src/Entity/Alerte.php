<?php

namespace App\Entity;

use App\Repository\AlerteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use ApiPlatform\Metadata\Get;
use ApiPlatform\Metadata\Post;
use ApiPlatform\Metadata\Put;
use ApiPlatform\Metadata\Delete;
use Symfony\Component\Serializer\Annotation\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: AlerteRepository::class)]
#[ApiResource(
    normalizationContext: ['groups' => ['alerte:read']],
    denormalizationContext: ['groups' => ['alerte:write']],
    operations: [
        new Get(),
        new Post(),
        new Put(),
        new Delete()
    ]
)]

#[ORM\HasLifecycleCallbacks]
class Alerte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['alerte:read'])]
    private ?int $id = null;

    #[ORM\Column(type: 'datetime')]
    #[Groups(['alerte:read', 'alerte:write'])]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(length: 255)]
    #[Groups(['alerte:read', 'alerte:write'])]
    #[Assert\NotBlank(message: 'Le statut est obligatoire.')]
    #[Assert\Choice(
        choices: ['EN_COURS', 'RESOLUE', 'ANNULEE'],
        message: 'Le statut doit être EN_COURS, RESOLUE ou ANNULEE.'
    )]
    private ?string $statut = 'EN_COURS';

    #[ORM\Column(type: 'integer')]
    #[Groups(['alerte:read', 'alerte:write'])]
    #[Assert\NotNull(message: 'L\'ID utilisateur est obligatoire.')]
    private ?int $userId = null;

    #[ORM\OneToMany(mappedBy: 'alerte', targetEntity: Historique::class, cascade: ['persist', 'remove'])]
    #[Groups(['alerte:read'])]
    private Collection $historiques;

    #[ORM\PrePersist]
    public function setDefaultDateCreation(): void
    {
        if ($this->dateCreation === null) {
            $this->dateCreation = new \DateTime();
        }
    }

    public function __construct()
    {
        $this->historiques = new ArrayCollection();
    }

    // Getters et setters

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(?\DateTimeInterface $dateCreation): static
    {
        $this->dateCreation = $dateCreation;
        return $this;
    }

    public function getStatut(): ?string
    {
        return $this->statut;
    }

    public function setStatut(string $statut): static
    {
        $this->statut = $statut;
        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): static
    {
        $this->userId = $userId;
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
