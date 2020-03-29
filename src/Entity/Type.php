<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\TypeRepository")
 */
class Type
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
     * @ORM\OneToMany(targetEntity="App\Entity\Property", mappedBy="type", orphanRemoval=true)
     */
    private $property;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Voiture", mappedBy="type", orphanRemoval=true)
     */
    private $voiture;

    public function __construct()
    {
        $this->property = new ArrayCollection();
        $this->voiture = new ArrayCollection();
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
     * @return Collection|property[]
     */
    public function getProperty(): Collection
    {
        return $this->property;
    }

    public function addProperty(property $property): self
    {
        if (!$this->property->contains($property)) {
            $this->property[] = $property;
            $property->setType($this);
        }

        return $this;
    }

    public function removeProperty(property $property): self
    {
        if ($this->property->contains($property)) {
            $this->property->removeElement($property);
            // set the owning side to null (unless already changed)
            if ($property->getType() === $this) {
                $property->setType(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|voiture[]
     */
    public function getVoiture(): Collection
    {
        return $this->voiture;
    }

    public function addVoiture(voiture $voiture): self
    {
        if (!$this->voiture->contains($voiture)) {
            $this->voiture[] = $voiture;
            $voiture->setType($this);
        }

        return $this;
    }

    public function removeVoiture(voiture $voiture): self
    {
        if ($this->voiture->contains($voiture)) {
            $this->voiture->removeElement($voiture);
            // set the owning side to null (unless already changed)
            if ($voiture->getType() === $this) {
                $voiture->setType(null);
            }
        }

        return $this;
    }
}
