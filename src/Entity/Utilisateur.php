<?php
namespace App\Entity;

use App\Repository\UtilisateurRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Security\Core\User\UserInterface;
use ApiPlatform\Metadata\ApiResource;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;

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

    #[ORM\Column(type: 'json')]
    private array $roles = ['ROLE_ETUDIANT'];

    #[ORM\Column]
    private ?string $password = null;

    #[ORM\OneToMany(targetEntity: Historique::class, mappedBy: 'utilisateur', cascade: ['persist', 'remove'])]
    private Collection $historiques;

    #[ORM\ManyToMany(targetEntity: Cohorte::class, inversedBy: 'utilisateurs')]
    private Collection $groupes;

    #[ORM\OneToMany(targetEntity: Blacklist::class, mappedBy: 'utilisateur')]
    private Collection $blacklist;

    public function __construct()
    {
        $this->historiques = new ArrayCollection();
        $this->groupes = new ArrayCollection();
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

    public function getUserIdentifier(): string
    {
        return (string) $this->email;
    }

    public function getRoles(): array
    {
        return $this->roles;
    }

    public function setRoles(array $roles): static
    {
        $this->roles = $roles;
        return $this;
    }

    public function updateRole(string $nouveauRole): void
    {
        if (!in_array($nouveauRole, ['ROLE_ETUDIANT', 'ROLE_SUPERVISEUR' ,'ROLE_ADMIN'])) {
            throw new \InvalidArgumentException('Rôle invalide.');
        }

        if (!in_array($nouveauRole, $this->roles)) {
            $this->roles[] = $nouveauRole;
        }
    }

    public function getPassword(): ?string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @param UserPasswordHasherInterface $passwordHasher
     * @return $this
     */
    public function setPassword(string $hashedPassword): static
    {
        $this->password = $hashedPassword; // Vous passez ici un mot de passe déjà haché
        return $this;
    }
    


    public function eraseCredentials(): void
    {
        // Logique pour effacer les informations sensibles
    }

    public function getHistoriques(): Collection
    {
        return $this->historiques;
    }

    public function addHistorique(Historique $historique): static
    {
        if (!$this->historiques->contains($historique)) {
            $this->historiques->add($historique);
            $historique->setUtilisateur($this);
        }

        return $this;
    }

    public function removeHistorique(Historique $historique): static
    {
        if ($this->historiques->removeElement($historique)) {
            if ($historique->getUtilisateur() === $this) {
                $historique->setUtilisateur(null);
            }
        }

        return $this;
    }

    public function getGroupes(): Collection
    {
        return $this->groupes;
    }

    public function addGroupe(Cohorte $groupe): static
    {
        if (!$this->groupes->contains($groupe)) {
            $this->groupes->add($groupe);
            $groupe->addUtilisateur($this);
        }

        return $this;
    }

    public function removeGroupe(Cohorte $groupe): static
    {
        if ($this->groupes->removeElement($groupe)) {
            $groupe->removeUtilisateur($this);
        }

        return $this;
    }

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
            if ($blacklist->getUtilisateur() === $this) {
                $blacklist->setUtilisateur(null);
            }
        }

        return $this;
    }
}
