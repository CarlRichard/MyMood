<?php

namespace App\Entity;

use App\Repository\BlacklistRepository;
use Doctrine\ORM\Mapping as ORM;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: BlacklistRepository::class)]
#[ApiResource]
class Blacklist
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?bool $EstBlacklist = null;

    #[ORM\ManyToOne(inversedBy: 'blacklist')]
    private ?Utilisateur $utilisateur = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function isEstBlacklist(): ?bool
    {
        return $this->EstBlacklist;
    }

    public function setEstBlacklist(bool $EstBlacklist): static
    {
        $this->EstBlacklist = $EstBlacklist;

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
}
