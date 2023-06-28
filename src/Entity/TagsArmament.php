<?php

namespace App\Entity;

use App\Repository\TagsArmamentRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TagsArmamentRepository::class)]
class TagsArmament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $name = null;

    #[ORM\ManyToMany(targetEntity: Armament::class, inversedBy: 'tagsArmaments')]
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
        }

        return $this;
    }

    public function removeArmament(Armament $armament): self
    {
        $this->armament->removeElement($armament);

        return $this;
    }
}
