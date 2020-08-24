<?php

namespace App\Entity;

use App\Repository\AttributeRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=AttributeRepository::class)
 */
class Attribute
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\ManyToOne(targetEntity=AttributeCategory::class, inversedBy="attributes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $attributeCategory;

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

    public function getAttributeCategory(): ?AttributeCategory
    {
        return $this->attributeCategory;
    }

    public function setAttributeCategory(?AttributeCategory $attributeCategory): self
    {
        $this->attributeCategory = $attributeCategory;

        return $this;
    }

    public function __toString()
    {
        return ($this->getAttributeCategory() ? ucfirst($this->getAttributeCategory()->getName()) . ' : ' : '') . $this->getName();
    }
}
