<?php

namespace App\Entity;

use App\Repository\FilesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;

#[ORM\Entity(repositoryClass: FilesRepository::class)]
class Files
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'text')]
    private $path;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\Column(type: 'datetime_immutable')]
    private $updated_at;

    #[ORM\ManyToMany(targetEntity: FilesCategories::class, inversedBy: 'files')]
    private $files_categories_id;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'files')]
    #[ORM\JoinColumn(nullable: false)]
    private $user_id;

    /**
     * @var File
     */
    private $file;

    public function __construct()
    {
        $this->files_categories_id = new ArrayCollection();
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
    public function getFilesCategoriesId(): Collection
    {
        return $this->files_categories_id;
    }

    public function addFilesCategoriesId(FilesCategories $filesCategoriesId): self
    {
        if (!$this->files_categories_id->contains($filesCategoriesId)) {
            $this->files_categories_id[] = $filesCategoriesId;
        }

        return $this;
    }

    public function removeFilesCategoriesId(FilesCategories $filesCategoriesId): self
    {
        $this->files_categories_id->removeElement($filesCategoriesId);

        return $this;
    }

    public function getUserId(): ?Users
    {
        return $this->user_id;
    }

    public function setUserId(?Users $user_id): self
    {
        $this->user_id = $user_id;

        return $this;
    }
    
    /**
     * @return File|null
     */
    public function getFile() {
        return $this->file;
    }

    /**
     * @param File $file
     * @return File|null
     */
    public function setFile(File $file) {
        return $this->file;
    }
}
