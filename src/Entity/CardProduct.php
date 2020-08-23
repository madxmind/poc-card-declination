<?php

namespace App\Entity;

use App\Repository\CardProductRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=CardProductRepository::class)
 */
class CardProduct
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=User::class, inversedBy="cardProducts")
     */
    private $user;

    /**
     * @ORM\ManyToOne(targetEntity=Product::class)
     */
    private $product;

    /**
     * @ORM\ManyToOne(targetEntity=ProductDeclination::class)
     */
    private $productDeclination;

    /**
     * @ORM\Column(type="smallint")
     */
    private $quantity;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

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

    public function getProductDeclination(): ?ProductDeclination
    {
        return $this->productDeclination;
    }

    public function setProductDeclination(?ProductDeclination $productDeclination): self
    {
        $this->productDeclination = $productDeclination;

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
}
