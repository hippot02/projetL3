<?php

namespace App\Entity;

use App\Repository\UploadRepository;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;


#[ORM\Entity(repositoryClass: UploadRepository::class)]
class Upload
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $userId = null;

    #[ORM\Column(length: 255)]
    private ?string $files = null;

    #[ORM\Column]
    private ?int $countDownload = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $filePassword = null;

    #[ORM\Column(length: 255, nullable: true)]
    private ?string $description = null;




     #[ORM\ManyToMany(targetEntity:"User")]

    private ?User $user ;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUserId(): ?int
    {
        return $this->userId;
    }

    public function setUserId(int $userId): self
    {
        $this->userId = $userId;

        return $this;
    }

    public function getFiles(): ?string
    {
        return $this->files;
    }

    public function setFiles(string $files): self
    {
        $this->files = $files;

        return $this;
    }

    public function getCountDownload(): ?int
    {
        return $this->countDownload;
    }

    public function setCountDownload(int $countDownload): self
    {
        $this->countDownload = $countDownload;

        return $this;
    }

    public function getFilePassword(): ?string
    {
        return $this->filePassword;
    }

    public function setFilePassword(?string $filePassword): self
    {
        $this->filePassword = $filePassword;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }
}
