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
    private ?string $message = null;

    #[ORM\Column(length: 255)]
    private ?string $mail = null;

    #[ORM\Column(length: 255)]
    private ?string $username = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMessage(): ?string
    {
        return $this->message;
    }

    public function setMessage(string $message): self
    {
        $this->message = $message;

        return $this;
    }

    public function getMailMessage(): ?string
    {
        return $this->mail;
    }

    public function setMailMessage(string $mailMessage): self
    {
        $this->mail = $mailMessage;

        return $this;
    }

    public function getUsernameMessage(): ?string
    {
        return $this->username;
    }

    public function setUsernameMessage(string $usernameMessage): self
    {
        $this->username = $usernameMessage;

        return $this;
    }
}
