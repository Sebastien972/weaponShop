<?php

namespace App\Entity;

use App\Repository\CaliberRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CaliberRepository::class)]
class Caliber
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?float $calibre = null;

    #[ORM\OneToMany(mappedBy: 'calibre', targetEntity: Armament::class)]
    private Collection $armament;

    public function __construct()
    {
        $this->armament = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getCalibre(): ?float
    {
        return $this->calibre;
    }

    public function setCalibre(float $calibre): self
    {
        $this->calibre = $calibre;

        return $this;
    }

    /**
     * @return Collection<int, Armament>
     */
    public function getArmament(): Collection
    {
        return $this->armament;
    }

    public function addArmament(Armament $armament): self
    {
        if (!$this->armament->contains($armament)) {
            $this->armament->add($armament);
            $armament->setCalibre($this);
        }

        return $this;
    }

    public function removeArmament(Armament $armament): self
    {
        if ($this->armament->removeElement($armament)) {
            // set the owning side to null (unless already changed)
            if ($armament->getCalibre() === $this) {
                $armament->setCalibre(null);
            }
        }

        return $this;
    }

    public function __toString()
    {
        return $this->calibre;
    }
}
