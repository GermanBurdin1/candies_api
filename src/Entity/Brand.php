<?php

namespace App\Entity;

use App\Repository\BrandRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: BrandRepository::class)]
class Brand
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    private ?string $name = null;

    /**
     * @var Collection<int, Candy>
     */
    #[ORM\OneToMany(targetEntity: Candy::class, mappedBy: 'brand')]
    private Collection $candies;

    public function __construct()
    {
        $this->candies = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): static
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return Collection<int, Candy>
     */
    public function getCandies(): Collection
    {
        return $this->candies;
    }

    public function addCandy(Candy $candy): static
    {
        if (!$this->candies->contains($candy)) {
            $this->candies->add($candy);
            $candy->setBrand($this);
        }

        return $this;
    }

    public function removeCandy(Candy $candy): static
    {
        if ($this->candies->removeElement($candy)) {
            // set the owning side to null (unless already changed)
            if ($candy->getBrand() === $this) {
                $candy->setBrand(null);
            }
        }

        return $this;
    }
}
