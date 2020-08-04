<?php

namespace App\Entity;

use App\Repository\DeclinationCategoryRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=DeclinationCategoryRepository::class)
 */
class DeclinationCategory
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=50)
     */
    private $reference;

    /**
     * @ORM\OneToMany(targetEntity=Declination::class, mappedBy="declinationCategory")
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

    public function getReference(): ?string
    {
        return $this->reference;
    }

    public function setReference(string $reference): self
    {
        $this->reference = $reference;

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
            $declination->setDeclinationCategory($this);
        }

        return $this;
    }

    public function removeDeclination(Declination $declination): self
    {
        if ($this->declinations->contains($declination)) {
            $this->declinations->removeElement($declination);
            // set the owning side to null (unless already changed)
            if ($declination->getDeclinationCategory() === $this) {
                $declination->setDeclinationCategory(null);
            }
        }

        return $this;
    }
}
