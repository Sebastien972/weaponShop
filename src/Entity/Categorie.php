<?php

namespace App\Entity;

use App\Repository\CategorieRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CategorieRepository::class)]
class Categorie
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;



    #[ORM\Column(length: 255, nullable: true)]
    private ?string $image = null;

    #[ORM\OneToMany(mappedBy: 'categorie', targetEntity: Armament::class)]
    private Collection $armament;

    public function __construct()
    {
        $this->armament = new ArrayCollection();
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

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    
    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }
    public function __toString()
    {
        return $this->name;
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
            $armament->setCategorie($this);
        }

        return $this;
    }

    public function removeArmament(Armament $armament): self
    {
        if ($this->armament->removeElement($armament)) {
            // set the owning side to null (unless already changed)
            if ($armament->getCategorie() === $this) {
                $armament->setCategorie(null);
            }
        }

        return $this;
    }
}
