<?php

namespace App\Entity;

use App\Repository\ProfilRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProfilRepository::class)]
class Profil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank (message:"nom is required")]
    #[ORM\Column(length: 255)]
    private ?string $Nom = null;

    #[Assert\NotBlank (message:"Prenom is required")]
    #[ORM\Column(length: 255)]
    private ?string $Prenom = null;


    #[Assert\NotBlank (message:"Age is required")]
    #[ORM\Column]
    private ?int $Age = null;

    #[Assert\Email (message:"The Email '{{ value }}' is not VALID")]
    #[Assert\NotBlank (message:"Email is required")]
    #[ORM\Column(length: 255)]
    private ?string $Email = null;


    #[Assert\NotBlank (message:"Adresse is required")]
    #[ORM\Column(length: 255)]
    private ?string $Adresse = null;

    #[ORM\OneToMany(mappedBy: 'profil', targetEntity: Network::class)]
    private Collection $networks;

    public function __construct()
    {
        $this->networks = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->Nom;
    }

    public function setNom(string $Nom): self
    {
        $this->Nom = $Nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->Prenom;
    }

    public function setPrenom(string $Prenom): self
    {
        $this->Prenom = $Prenom;

        return $this;
    }

    public function getAge(): ?int
    {
        return $this->Age;
    }

    public function setAge(int $Age): self
    {
        $this->Age = $Age;

        return $this;
    }

    public function getEmail(): ?string
    {
        return $this->Email;
    }

    public function setEmail(string $Email): self
    {
        $this->Email = $Email;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->Adresse;
    }

    public function setAdresse(string $Adresse): self
    {
        $this->Adresse = $Adresse;

        return $this;
    }

    /**
     * @return Collection<int, Network>
     */
    public function getNetworks(): Collection
    {
        return $this->networks;
    }

    public function addNetwork(Network $network): self
    {
        if (!$this->networks->contains($network)) {
            $this->networks->add($network);
            $network->setProfil($this);
        }

        return $this;
    }

    public function removeNetwork(Network $network): self
    {
        if ($this->networks->removeElement($network)) {
            // set the owning side to null (unless already changed)
            if ($network->getProfil() === $this) {
                $network->setProfil(null);
            }
        }

        return $this;
    }
}
