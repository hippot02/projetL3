<?php

namespace App\Entity;

use App\Repository\AccueilRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccueilRepository::class)]
class Accueil
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $logo = null;

    #[ORM\Column]
    private ?int $totalFilesOnSite = null;

    #[ORM\Column(length: 255)]
    private ?string $textOnHome = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getLogo(): ?string
    {
        return $this->logo;
    }

    public function setLogo(?string $logo): self
    {
        $this->logo = $logo;

        return $this;
    }

    public function getTotalFilesOnSite(): ?int
    {
        return $this->totalFilesOnSite;
    }

    public function setTotalFilesOnSite(int $totalFilesOnSite): self
    {
        $this->totalFilesOnSite = $totalFilesOnSite;

        return $this;
    }

    public function getTextOnHome(): ?string
    {
        return $this->textOnHome;
    }

    public function setTextOnHome(string $textOnHome): self
    {
        $this->textOnHome = $textOnHome;

        return $this;
    }
}
