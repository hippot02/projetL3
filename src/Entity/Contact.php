<?php

namespace App\Entity;

use App\Repository\ContactRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContactRepository::class)]
class Contact
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;
    
    #[ORM\Column(length: 255)]

    #[ORM\Column]
    private ?int $idContact = null;

    #[ORM\Column]
    private ?int $Userid = null;

    #[ORM\Column(length: 255, nullable: true)]

    private ?string $message = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;
    #[ORM\ManyToMany(targetEntity:"User", inversedBy: "Contact")]
    private ?User $user ;

    public function getId(): ?int
    {
        return $this->id;
    }


    public function getIdContact(): ?int
    {
        return $this->idContact;
    }

    public function setIdContact(int $idContact): self
    {
        $this->idContact = $idContact;

        return $this;
    }

    public function getUserid(): ?int
    {
        return $this->Userid;
    }

    public function setUserid(int $Userid): self
    {
        $this->Userid = $Userid;

        return $this;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }


    public function setMessage(?string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getMail(): ?string
    {
        return $this->mail;
    }

    public function setMail(string $mail): self
    {
        $this->mail = $mail;

        return $this;
    }

    public function getUsername(): ?string
    {
        return $this->username;
    }

    public function setUsername(string $username): self
    {
        $this->username = $username;

        return $this;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

}
