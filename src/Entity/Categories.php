<?php

namespace App\Entity;

use App\Repository\CategoriesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategoriesRepository::class)]
class Categories
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $name;

    #[ORM\Column(type: 'datetime')]
    private $created_at;

    #[ORM\ManyToOne(targetEntity: self::class, inversedBy: 'parent')]
    private $categories;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: self::class)]
    private $parent;

    #[ORM\OneToMany(mappedBy: 'categories', targetEntity: Forums::class)]
    private $forums;

    public function __construct()
    {
        $this->parent = new ArrayCollection();
        $this->forums = new ArrayCollection();
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

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getCategories(): ?self
    {
        return $this->categories;
    }

    public function setCategories(?self $categories): self
    {
        $this->categories = $categories;

        return $this;
    }

    /**
     * @return Collection<int, self>
     */
    public function getParent(): Collection
    {
        return $this->parent;
    }

    public function addParent(self $parent): self
    {
        if (!$this->parent->contains($parent)) {
            $this->parent[] = $parent;
            $parent->setCategories($this);
        }

        return $this;
    }

    public function removeParent(self $parent): self
    {
        if ($this->parent->removeElement($parent)) {
            // set the owning side to null (unless already changed)
            if ($parent->getCategories() === $this) {
                $parent->setCategories(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Forums>
     */
    public function getForums(): Collection
    {
        return $this->forums;
    }

    public function addForum(Forums $forum): self
    {
        if (!$this->forums->contains($forum)) {
            $this->forums[] = $forum;
            $forum->setCategories($this);
        }

        return $this;
    }

    public function removeForum(Forums $forum): self
    {
        if ($this->forums->removeElement($forum)) {
            // set the owning side to null (unless already changed)
            if ($forum->getCategories() === $this) {
                $forum->setCategories(null);
            }
        }

        return $this;
    }
}
