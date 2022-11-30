<?php

namespace App\Entity;

use App\Repository\MessagesRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: MessagesRepository::class)]
class Messages
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $content;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\Column(type: 'integer')]
    private $user_id;

    #[ORM\ManyToOne(targetEntity: Forums::class, inversedBy: 'messages')]
    #[ORM\JoinColumn(nullable: false)]
    private $forum;

    #[ORM\Column(type: 'integer', nullable: true)]
    private $file_id;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(string $content): self
    {
        $this->content = $content;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUserId(): ?int
    {
        return $this->user_id;
    }

    public function setUserId(int $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }

    public function getForum(): ?Forums
    {
        return $this->forum;
    }

    public function setForum(?Forums $forum): self
    {
        $this->forum = $forum;

        return $this;
    }

    public function getFileId(): ?int
    {
        return $this->file_id;
    }

    public function setFileId(?int $file_id): self
    {
        $this->file_id = $file_id;

        return $this;
    }
}
