<?php

namespace App\Entity;

use App\Repository\FilesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilesRepository::class)]
class Files
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $name;

    #[ORM\OneToMany(mappedBy: 'files', targetEntity: Users::class)]
    private $user_id;

    #[ORM\Column(type: 'text')]
    private $path;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updated_at;

    #[ORM\ManyToMany(targetEntity: FilesCategories::class, mappedBy: 'files_categories')]
    private $filesCategories;

    #[ORM\ManyToMany(targetEntity: Chats::class, inversedBy: 'files')]
    private $chats_id;

    public function __construct()
    {
        $this->user_id = new ArrayCollection();
        $this->filesCategories = new ArrayCollection();
        $this->chats_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getUserId(): Collection
    {
        return $this->user_id;
    }

    public function addUserId(Users $userId): self
    {
        if (!$this->user_id->contains($userId)) {
            $this->user_id[] = $userId;
            $userId->setFiles($this);
        }

        return $this;
    }

    public function removeUserId(Users $userId): self
    {
        if ($this->user_id->removeElement($userId)) {
            // set the owning side to null (unless already changed)
            if ($userId->getFiles() === $this) {
                $userId->setFiles(null);
            }
        }

        return $this;
    }

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdatedAt(): ?\DateTimeImmutable
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeImmutable $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    /**
     * @return Collection<int, FilesCategories>
     */
    public function getFilesCategories(): Collection
    {
        return $this->filesCategories;
    }

    public function addFilesCategory(FilesCategories $filesCategory): self
    {
        if (!$this->filesCategories->contains($filesCategory)) {
            $this->filesCategories[] = $filesCategory;
            $filesCategory->addFilesCategory($this);
        }

        return $this;
    }

    public function removeFilesCategory(FilesCategories $filesCategory): self
    {
        if ($this->filesCategories->removeElement($filesCategory)) {
            $filesCategory->removeFilesCategory($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, Chats>
     */
    public function getChatsId(): Collection
    {
        return $this->chats_id;
    }

    public function addChatsId(Chats $chatsId): self
    {
        if (!$this->chats_id->contains($chatsId)) {
            $this->chats_id[] = $chatsId;
        }

        return $this;
    }

    public function removeChatsId(Chats $chatsId): self
    {
        $this->chats_id->removeElement($chatsId);

        return $this;
    }
}
