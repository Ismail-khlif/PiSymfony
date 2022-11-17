<?php

namespace App\Entity;

use App\Repository\NetworkRepository;
use Symfony\Component\Validator\Constraints as Assert;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: NetworkRepository::class)]
class Network
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[Assert\NotBlank (message:"Amis is required")]
    #[ORM\Column(length: 255)]
    private ?string $Amis = null;

    #[Assert\NotBlank (message:"Discussion is required")]
    #[ORM\Column(length: 255)]
    private ?string $Discussion = null;

    #[Assert\NotBlank (message:"Profil is required")]
    #[ORM\ManyToOne(inversedBy: 'networks')]
    private ?Profil $profil = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getAmis(): ?string
    {
        return $this->Amis;
    }

    public function setAmis(string $Amis): self
    {
        $this->Amis = $Amis;

        return $this;
    }

    public function getDiscussion(): ?string
    {
        return $this->Discussion;
    }

    public function setDiscussion(string $Discussion): self
    {
        $this->Discussion = $Discussion;

        return $this;
    }

    public function getProfil(): ?Profil
    {
        return $this->profil;
    }

    public function setProfil(?Profil $profil): self
    {
        $this->profil = $profil;

        return $this;
    }
}
