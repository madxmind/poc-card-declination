<?php

namespace App\Entity;

use App\Repository\DeclinationRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeclinationRepository::class)
 */
class Declination
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
     * @ORM\ManyToOne(targetEntity=DeclinationCategory::class, inversedBy="declinations")
     */
    private $declinationCategory;

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

    public function getDeclinationCategory(): ?DeclinationCategory
    {
        return $this->declinationCategory;
    }

    public function setDeclinationCategory(?DeclinationCategory $declinationCategory): self
    {
        $this->declinationCategory = $declinationCategory;

        return $this;
    }
}
