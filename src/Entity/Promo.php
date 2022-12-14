<?php

namespace App\Entity;

use App\Repository\PromoRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: PromoRepository::class)]
class Promo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\Column(type: 'string', length: 40)]
    private $name;

    #[ORM\Column(type: 'date')]
    private $StartDate;

    #[ORM\Column(type: 'string', length: 40)]
    private $center;

    #[ORM\Column(type: 'string', length: 100)]
    private $formation;

    #[ORM\OneToMany(mappedBy: 'promo', targetEntity: Users::class)]
    private $Promo_id;

    public function __construct()
    {
        $this->Promo_id = new ArrayCollection();
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

    public function getStartDate(): ?\DateTimeInterface
    {
        return $this->StartDate;
    }

    public function setStartDate(\DateTimeInterface $StartDate): self
    {
        $this->StartDate = $StartDate;

        return $this;
    }

    public function getCenter(): ?string
    {
        return $this->center;
    }

    public function setCenter(string $center): self
    {
        $this->center = $center;

        return $this;
    }

    public function getFormation(): ?string
    {
        return $this->formation;
    }

    public function setFormation(string $formation): self
    {
        $this->formation = $formation;

        return $this;
    }

    /**
     * @return Collection<int, Users>
     */
    public function getPromoId(): Collection
    {
        return $this->Promo_id;
    }

    public function addPromoId(Users $promoId): self
    {
        if (!$this->Promo_id->contains($promoId)) {
            $this->Promo_id[] = $promoId;
            $promoId->setPromo($this);
        }

        return $this;
    }

    public function removePromoId(Users $promoId): self
    {
        if ($this->Promo_id->removeElement($promoId)) {
            // set the owning side to null (unless already changed)
            if ($promoId->getPromo() === $this) {
                $promoId->setPromo(null);
            }
        }

        return $this;
    }
}
