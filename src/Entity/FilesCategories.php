<?php

namespace App\Entity;

use App\Repository\FilesCategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: FilesCategoriesRepository::class)]
class FilesCategories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updated_at;

    #[ORM\ManyToMany(targetEntity: Files::class, inversedBy: 'filesCategories')]
    private $file_id;

    public function __construct()
    {
        $this->file_id = new ArrayCollection();
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
     * @return Collection<int, Files>
     */
    public function getFileId(): Collection
    {
        return $this->file_id;
    }

    public function addFileId(Files $fileId): self
    {
        if (!$this->file_id->contains($fileId)) {
            $this->file_id[] = $fileId;
        }

        return $this;
    }

    public function removeFileId(Files $fileId): self
    {
        $this->file_id->removeElement($fileId);

        return $this;
    }
}
