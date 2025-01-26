<?php
namespace App\Entity;

use App\Repository\AlerteRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\Serializer\Attribute\Groups;

#[ORM\Entity(repositoryClass: AlerteRepository::class)]
#[ApiResource]
class Alerte
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\OneToMany(targetEntity: Historique::class, mappedBy: 'alerte', cascade: ['persist', 'remove'])]
    private Collection $historiques;

    #[ORM\Column(type: "datetime")]
    #[Groups(['alerte:read'])]
    private ?\DateTimeInterface $dateCreation = null;

    #[ORM\Column(length: 255)]
    #[Groups(['alerte:read', 'alerte:write'])]
    private ?string $statut = 'EN_COURS'; // Valeur par défaut


    //stock l'id non null
    #[ORM\Column(type: "integer")]
    #[Groups(['alerte:read'])]
    private ?int $userId = null;


    // date de création à aujourd'hui si null
    #[ORM\PrePersist]
    public function setDefaultDateCreation(): void
    {
        if ($this->dateCreation === null) {
            $this->dateCreation = new \DateTime(); // Définit la date actuelle si elle n'est pas spécifiée
        }
    }

    public function __construct()
    {
        $this->historiques = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateCreation(): ?\DateTimeInterface
    {
        return $this->dateCreation;
    }

    public function setDateCreation(\DateTimeInterface $dateCreation): static
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
