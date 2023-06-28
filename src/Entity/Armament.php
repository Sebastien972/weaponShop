<?php

namespace App\Entity;

use App\Repository\ArmamentRepository;
use DateTime;
use DateTimeImmutable;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Index;
use Doctrine\ORM\Mapping\Table;
use phpDocumentor\Reflection\DocBlock\Description;


#[ORM\Entity(repositoryClass: ArmamentRepository::class)]
#[ORM\Index(name: 'armamen', columns: ['name', 'description'], flags: ['fulltext'])]
class Armament
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 25)]
    private ?string $name = null;

    #[ORM\Column(type: Types::TEXT)]
    private ?string $description = null;

    #[ORM\Column(length: 255)]
    private ?string $image = null;

    #[ORM\Column]
    private ?float $price = null;



    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $moreInformation = null;

    #[ORM\ManyToMany(targetEntity: TagsArmament::class, mappedBy: 'armament')]
    private Collection $tagsArmaments;

    #[ORM\OneToMany(mappedBy: 'armament', targetEntity: RelatedArmament::class)]
    private Collection $relatedArmaments;

    #[ORM\Column]
    private ?int $quantity = null;

    #[ORM\Column]
    private ?\DateTimeImmutable $createdAt = null;

    #[ORM\Column(type: Types::TEXT, nullable: true)]
    private ?string $tags = null;

    #[ORM\Column(length: 255)]
    private ?string $slug = null;

    #[ORM\Column(nullable: true)]
    private ?bool $mostPopular = null;

    #[ORM\Column(length: 255)]
    private ?string $image2 = null;

    #[ORM\Column(nullable: true)]
    private ?float $weight = null;

    #[ORM\ManyToOne(inversedBy: 'armament')]
    private ?Categorie $categorie = null;

    #[ORM\ManyToOne(inversedBy: 'armament')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Caliber $calibre = null;

    

    public function __construct()
    {
        $this->tagsArmaments = new ArrayCollection();
        $this->relatedArmaments = new ArrayCollection();
        $this->createdAt = new DateTimeImmutable();
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

    public function setImage(string $image): self
    {
        $this->image = $image;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    

  

    public function getMoreInformation(): ?string
    {
        return $this->moreInformation;
    }

    public function setMoreInformation(?string $moreInformation): self
    {
        $this->moreInformation = $moreInformation;

        return $this;
    }

    

    /**
     * @return Collection<int, TagsArmament>
     */
    public function getTagsArmaments(): Collection
    {
        return $this->tagsArmaments;
    }

    public function addTagsArmament(TagsArmament $tagsArmament): self
    {
        if (!$this->tagsArmaments->contains($tagsArmament)) {
            $this->tagsArmaments->add($tagsArmament);
            $tagsArmament->addArmament($this);
        }

        return $this;
    }

    public function removeTagsArmament(TagsArmament $tagsArmament): self
    {
        if ($this->tagsArmaments->removeElement($tagsArmament)) {
            $tagsArmament->removeArmament($this);
        }

        return $this;
    }

    /**
     * @return Collection<int, RelatedArmament>
     */
    public function getRelatedArmaments(): Collection
    {
        return $this->relatedArmaments;
    }

    public function addRelatedArmament(RelatedArmament $relatedArmament): self
    {
        if (!$this->relatedArmaments->contains($relatedArmament)) {
            $this->relatedArmaments->add($relatedArmament);
            $relatedArmament->setArmament($this);
        }

        return $this;
    }

    public function removeRelatedArmament(RelatedArmament $relatedArmament): self
    {
        if ($this->relatedArmaments->removeElement($relatedArmament)) {
            // set the owning side to null (unless already changed)
            if ($relatedArmament->getArmament() === $this) {
                $relatedArmament->setArmament(null);
            }
        }

        return $this;
    }

    public function getQuantity(): ?int
    {
        return $this->quantity;
    }

    public function setQuantity(int $quantity): self
    {
        $this->quantity = $quantity;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeImmutable
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeImmutable $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getTags(): ?string
    {
        return $this->tags;
    }

    public function setTags(?string $tags): self
    {
        $this->tags = $tags;

        return $this;
    }

    public function getSlug(): ?string
    {
        return $this->slug;
    }

    public function setSlug(string $slug): self
    {
        $this->slug = $slug;

        return $this;
    }

    public function isMostPopular(): ?bool
    {
        return $this->mostPopular;
    }

    public function setMostPopular(?bool $mostPopular): self
    {
        $this->mostPopular = $mostPopular;

        return $this;
    }

    public function getImage2(): ?string
    {
        return $this->image2;
    }

    public function setImage2(string $image2): self
    {
        $this->image2 = $image2;

        return $this;
    }

    public function getWeight(): ?float
    {
        return $this->weight;
    }

    public function setWeight(?float $weight): self
    {
        $this->weight = $weight;

        return $this;
    }
    public function __toString()
    {
        return $this->name;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

        return $this;
    }

    public function getCalibre(): ?Caliber
    {
        return $this->calibre;
    }

    public function setCalibre(?Caliber $calibre): self
    {
        $this->calibre = $calibre;

        return $this;
    }

   
}
