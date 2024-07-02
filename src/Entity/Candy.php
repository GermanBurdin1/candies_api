<?php

namespace App\Entity;

use App\Repository\CandyRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Serializer\Attribute\Groups;
use Symfony\Component\Validator\Constraints as Assert;

#[ORM\Entity(repositoryClass: CandyRepository::class)]
class Candy
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    #[Groups(['candy:read'])]
    private ?int $id = null;

    #[ORM\Column(length: 50)]
    #[Groups(['candy:read'])]
    #[Assert\NotBlank]
    private ?string $name = null;

    #[ORM\Column]
    #[Groups(['candy:read'])]
    private ?bool $isSour = null;

    #[ORM\Column(length: 255, nullable: true)]
    #[Groups(['candy:read'])]
    private ?string $picture = null;

    /**
     * @var Collection<int, Color>
     */
    #[ORM\ManyToMany(targetEntity: Color::class, inversedBy: 'candies')]
    #[Groups(['candy:read'])]
    private Collection $colors;

    /**
     * @var Collection<int, Taste>
     */
    #[ORM\ManyToMany(targetEntity: Taste::class, inversedBy: 'candies')]
    #[Groups(['candy:read'])]
    private Collection $tastes;

    #[ORM\ManyToOne(inversedBy: 'candies')]
    #[ORM\JoinColumn(nullable: false)]
    #[Groups(['candy:read'])]
    private ?Brand $brand = null;

    public function __construct()
    {
        $this->colors = new ArrayCollection();
        $this->tastes = new ArrayCollection();
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

    public function isSour(): ?bool
    {
        return $this->isSour;
    }

    public function setSour(bool $isSour): static
    {
        $this->isSour = $isSour;

        return $this;
    }

    public function getPicture(): ?string
    {
        return $this->picture;
    }

    public function setPicture(?string $picture): static
    {
        $this->picture = $picture;

        return $this;
    }

    /**
     * @return Collection<int, Color>
     */
    public function getColors(): Collection
    {
        return $this->colors;
    }

    public function addColor(Color $color): static
    {
        if (!$this->colors->contains($color)) {
            $this->colors->add($color);
        }

        return $this;
    }

    public function removeColor(Color $color): static
    {
        $this->colors->removeElement($color);

        return $this;
    }

    /**
     * @return Collection<int, Taste>
     */
    public function getTastes(): Collection
    {
        return $this->tastes;
    }

    public function addTaste(Taste $taste): static
    {
        if (!$this->tastes->contains($taste)) {
            $this->tastes->add($taste);
        }

        return $this;
    }

    public function removeTaste(Taste $taste): static
    {
        $this->tastes->removeElement($taste);

        return $this;
    }

    public function getBrand(): ?Brand
    {
        return $this->brand;
    }

    public function setBrand(?Brand $brand): static
    {
        $this->brand = $brand;

        return $this;
    }
}
