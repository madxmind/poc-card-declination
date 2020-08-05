<?php

namespace App\Entity;

use App\Repository\ProductDeclinationRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ProductDeclinationRepository::class)
 */
class ProductDeclination
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="smallint")
     */
    private $quantity;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class, inversedBy="productDeclinations", fetch="EAGER")
     */
    private $product;

    /**
     * @ORM\ManyToMany(targetEntity=Declination::class, fetch="EAGER")
     */
    private $declinations;

    public function __construct()
    {
        $this->declinations = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
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

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getProduct(): ?Product
    {
        return $this->product;
    }

    public function setProduct(?Product $product): self
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Collection|Declination[]
     */
    public function getDeclinations(): Collection
    {
        return $this->declinations;
    }

    public function addDeclination(Declination $declination): self
    {
        if (!$this->declinations->contains($declination)) {
            $this->declinations[] = $declination;
        }

        return $this;
    }

    public function removeDeclination(Declination $declination): self
    {
        if ($this->declinations->contains($declination)) {
            $this->declinations->removeElement($declination);
        }

        return $this;
    }
}
