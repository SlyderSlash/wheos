<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\FilesRepository;
use DateTimeImmutable;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;
use Symfony\Component\Validator\Constraints\File;

#[ORM\Entity(repositoryClass: FilesRepository::class)]
class Files
{
    #[File(
        maxSize: '1024k',
    )]
    protected $bioFile;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'text')]
    private $name;

    #[ORM\ManyToOne(targetEntity: Users::class, inversedBy: 'files')]
    #[ORM\JoinColumn(nullable: false)]
    private $user_id;

    #[ORM\ManyToMany(targetEntity: Chats::class, inversedBy: 'files')]
    private $chats_id;

    #[ORM\ManyToMany(targetEntity: Calendars::class, inversedBy: 'message_id')]
    private $calendar_id;

    #[ORM\ManyToMany(targetEntity: Messages::class, inversedBy: 'files')]
    private $message_id;

    #[ORM\ManyToMany(targetEntity: FilesCategories::class, mappedBy: 'file_id')]
    private $filesCategories;

    #[ORM\Column(type: 'datetime_immutable', options: ["default"=> new DateTimeImmutable('now')])]
    private $created_at;

    #[ORM\Column(type: 'datetime_immutable', options: ["default"=> new DateTimeImmutable('now')])]
    private $updated_at;

    #[ORM\Column(type: 'text')]
    private $path;

    public function __construct()
    {
        $this->chats_id = new ArrayCollection();
        $this->calendar_id = new ArrayCollection();
        $this->message_id = new ArrayCollection();
        $this->filesCategories = new ArrayCollection();
        $this->created_at = new DateTimeImmutable();
        $this->updated_at = new DateTimeImmutable();
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

    /**
     * @return Collection<int, Calendars>
     */
    public function getCalendarId(): Collection
    {
        return $this->calendar_id;
    }

    public function addCalendarId(Calendars $calendarId): self
    {
        if (!$this->calendar_id->contains($calendarId)) {
            $this->calendar_id[] = $calendarId;
        }

        return $this;
    }

    public function removeCalendarId(Calendars $calendarId): self
    {
        $this->calendar_id->removeElement($calendarId);

        return $this;
    }

    /**
     * @return Collection<int, Messages>
     */
    public function getMessageId(): Collection
    {
        return $this->message_id;
    }

    public function addMessageId(Messages $messageId): self
    {
        if (!$this->message_id->contains($messageId)) {
            $this->message_id[] = $messageId;
        }

        return $this;
    }

    public function removeMessageId(Messages $messageId): self
    {
        $this->message_id->removeElement($messageId);

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
            $filesCategory->addFileId($this);
        }

        return $this;
    }

    public function removeFilesCategory(FilesCategories $filesCategory): self
    {
        if ($this->filesCategories->removeElement($filesCategory)) {
            $filesCategory->removeFileId($this);
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeImmutable $created_at): self
    {
        $this->created_at = new DateTimeImmutable();

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

    public function getPath(): ?string
    {
        return $this->path;
    }

    public function setPath(string $path): self
    {
        $this->path = $path;

        return $this;
    }
}
