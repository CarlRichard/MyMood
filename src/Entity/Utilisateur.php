<?php

namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;

#[ORM\Entity(repositoryClass: UtilisateurRepository::class)]
#[ORM\UniqueConstraint(name: 'UNIQ_IDENTIFIER_EMAIL', fields: ['email'])]
#[ApiResource]
class Utilisateur implements UserInterface, PasswordAuthenticatedUserInterface
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 180, unique: true)]
    private ?string $email = null;

    /**
     * @var string The Utilisateur role
     */
    #[ORM\Column(type: 'string')]
    private ?string $roles = 'ROLE_USER'; // Valeur par défaut 'ROLE_USER'

    /**
     * @var string The hashed password
     */
    #[ORM\Column]
    private ?string $password = null;

    /**
     * @var Collection<int, Cohorte>
     */
    #[ORM\ManyToMany(targetEntity: Cohorte::class, inversedBy: 'utilisateurs')]
    private Collection $groupe;

    /**
     * @var Collection<int, Blacklist>
     */
    #[ORM\OneToMany(targetEntity: Blacklist::class, mappedBy: 'utilisateur')]
    private Collection $blacklist;

    #[ORM\ManyToOne(inversedBy: 'utilisateurs')]
    private ?Alerte $alerte = null;

    public function __construct()
    {
        $this->groupe = new ArrayCollection();
        $this->blacklist = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): static
    {
        $this->email = $email;

        return $this;
    }

    /**
     * A visual identifier that represents this Utilisateur.
     *
     * @see UserInterface
     */
    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     *
     * @return array<string> Le tableau contient un seul rôle
     */
    public function getRoles(): array
    {
        return [$this->roles]; // Retourne un tableau avec un seul rôle
    }

    /**
     * @param string $role Le rôle de l'utilisateur
     */
    public function setRoles(string $role): static
    {
        $this->roles = $role;

        return $this;
    }

    /**
     * @see PasswordAuthenticatedUserInterface
     */
    public function getPassword(): ?string
    {
        return $this->password;
    }

    public function setPassword(string $password): static
    {
        $this->password = $password;

        return $this;
    }

    /**
     * Removes sensitive data from the user.
     *
     * @see UserInterface
     */
    public function eraseCredentials(): void
    {
        // Clear temporary, sensitive data if needed.
        // Example: $this->plainPassword = null;
    }

    /**
     * @return Collection<int, Cohorte>
     */
    public function getGroupe(): Collection
    {
        return $this->groupe;
    }

    public function addGroupe(Cohorte $groupe): static
    {
        if (!$this->groupe->contains($groupe)) {
            $this->groupe->add($groupe);
        }

        return $this;
    }

    public function removeGroupe(Cohorte $groupe): static
    {
        $this->groupe->removeElement($groupe);

        return $this;
    }

    /**
     * @return Collection<int, Blacklist>
     */
    public function getBlacklist(): Collection
    {
        return $this->blacklist;
    }

    public function addBlacklist(Blacklist $blacklist): static
    {
        if (!$this->blacklist->contains($blacklist)) {
            $this->blacklist->add($blacklist);
            $blacklist->setUtilisateur($this);
        }

        return $this;
    }

    public function removeBlacklist(Blacklist $blacklist): static
    {
        if ($this->blacklist->removeElement($blacklist)) {
            // set the owning side to null (unless already changed)
            if ($blacklist->getUtilisateur() === $this) {
                $blacklist->setUtilisateur(null);
            }
        }

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
