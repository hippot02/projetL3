<?php

namespace App\Entity;

use App\Repository\AcceuilRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AcceuilRepository::class)]
class Acceuil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $logo = null;

    #[ORM\Column]
    private ?int $nbTotalFic = null;

    #[ORM\Column(length: 255)]
    private ?string $texte = null;

    #[ORM\Column(length: 255)]
    private ?string $imgSlide = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getNbTotalFic(): ?int
    {
        return $this->nbTotalFic;
    }

    public function setNbTotalFic(int $nbTotalFic): self
    {
        $this->nbTotalFic = $nbTotalFic;

        return $this;
    }

    public function getTexte(): ?string
    {
        return $this->texte;
    }

    public function setTexte(string $texte): self
    {
        $this->texte = $texte;

        return $this;
    }

    public function getImgSlide(): ?string
    {
        return $this->imgSlide;
    }

    public function setImgSlide(string $imgSlide): self
    {
        $this->imgSlide = $imgSlide;

        return $this;
    }
}
