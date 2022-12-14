<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
class Account
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\OneToOne(targetEntity: Users::class, cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private $users_id;

    #[ORM\Column(type: 'text', nullable: true)]
    private $about_me;

    #[ORM\Column(type: 'blob', nullable: true)]
    private $avatar;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsersId(): ?Users
    {
        return $this->users_id;
    }

    public function setUsersId(Users $users_id): self
    {
        $this->users_id = $users_id;

        return $this;
    }

    public function getAboutMe(): ?string
    {
        return $this->about_me;
    }

    public function setAboutMe(?string $about_me): self
    {
        $this->about_me = $about_me;

        return $this;
    }

    public function getAvatar()
    {
        return $this->avatar;
    }

    public function setAvatar($avatar): self
    {
        $this->avatar = $avatar;

        return $this;
    }
}
