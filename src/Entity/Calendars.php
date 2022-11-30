<?php

namespace App\Entity;

use App\Repository\CalendarsRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CalendarsRepository::class)]
class Calendars
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'integer')]
    private $time_limit;

    #[ORM\Column(type: 'datetime_immutable')]
    private $created_at;

    #[ORM\Column(type: 'datetime_immutable')]
    private $finish_at;

    #[ORM\Column(type: 'string', length: 150)]
    private $categorie;

    #[ORM\Column(type: 'string', length: 150)]
    private $task;

    #[ORM\Column(type: 'boolean')]
    private $remote;

    #[ORM\ManyToMany(targetEntity: Files::class, mappedBy: 'calendar_id')]
    private $message_id;

    public function __construct()
    {
        $this->message_id = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTimeLimit(): ?int
    {
        return $this->time_limit;
    }

    public function setTimeLimit(int $time_limit): self
    {
        $this->time_limit = $time_limit;

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

    public function getFinishAt(): ?\DateTimeImmutable
    {
        return $this->finish_at;
    }

    public function setFinishAt(\DateTimeImmutable $finish_at): self
    {
        $this->finish_at = $finish_at;

        return $this;
    }

    public function getCategorie(): ?string
    {
        return $this->categorie;
    }

    public function setCategorie(string $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getTask(): ?string
    {
        return $this->task;
    }

    public function setTask(string $task): self
    {
        $this->task = $task;

        return $this;
    }

    public function isRemote(): ?bool
    {
        return $this->remote;
    }

    public function setRemote(bool $remote): self
    {
        $this->remote = $remote;

        return $this;
    }

    /**
     * @return Collection<int, Files>
     */
    public function getMessageId(): Collection
    {
        return $this->message_id;
    }

    public function addMessageId(Files $messageId): self
    {
        if (!$this->message_id->contains($messageId)) {
            $this->message_id[] = $messageId;
            $messageId->addCalendarId($this);
        }

        return $this;
    }

    public function removeMessageId(Files $messageId): self
    {
        if ($this->message_id->removeElement($messageId)) {
            $messageId->removeCalendarId($this);
        }

        return $this;
    }
}
