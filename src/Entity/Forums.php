<?php

namespace App\Entity;

use App\Repository\ForumsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ForumsRepository::class)]
class Forums
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 255)]
    private $title;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'boolean')]
    private $isResolved = false;

    #[ORM\Column(type: 'boolean')]
    private $isClosed = false;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'forums')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\ManyToOne(targetEntity: Categories::class)]
    #[ORM\JoinColumn(nullable: false)]
    private $category;

    #[ORM\OneToMany(mappedBy: 'forum', targetEntity: ForumMessages::class)]
    private $forumMessages;

    public function __construct()
    {
        $this->forumMessages = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function isIsResolved(): ?bool
    {
        return $this->isResolved;
    }

    public function setIsResolved(bool $isResolved): self
    {
        $this->isResolved = $isResolved;

        return $this;
    }

    public function isIsClosed(): ?bool
    {
        return $this->isClosed;
    }

    public function setIsClosed(bool $isClosed): self
    {
        $this->isClosed = $isClosed;

        return $this;
    }

    public function getUser(): ?Users
    {
        return $this->user;
    }

    public function setUser(?Users $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCategory(): ?Categories
    {
        return $this->category;
    }

    public function setCategory(?Categories $category): self
    {
        $this->category = $category;

        return $this;
    }

    /**
     * @return Collection<int, ForumMessages>
     */
    public function getForumMessages(): Collection
    {
        return $this->forumMessages;
    }

    public function addForumMessage(ForumMessages $forumMessage): self
    {
        if (!$this->forumMessages->contains($forumMessage)) {
            $this->forumMessages[] = $forumMessage;
            $forumMessage->setForum($this);
        }

        return $this;
    }

    public function removeForumMessage(ForumMessages $forumMessage): self
    {
        if ($this->forumMessages->removeElement($forumMessage)) {
            // set the owning side to null (unless already changed)
            if ($forumMessage->getForum() === $this) {
                $forumMessage->setForum(null);
            }
        }

        return $this;
    }
}
