<?php

namespace App\Entity;

use App\Repository\RelatedArmamentRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: RelatedArmamentRepository::class)]
class RelatedArmament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'relatedArmaments')]
    private ?Armament $armament = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getArmament(): ?Armament
    {
        return $this->armament;
    }

    public function setArmament(?Armament $armament): self
    {
        $this->armament = $armament;

        return $this;
    }
}
