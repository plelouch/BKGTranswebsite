<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\LocationRepository")
 */
class Location
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="date")
     */
    private $dateLocation;

    /**
     * @ORM\Column(type="datetime")
     */
    private $departAt;

    /**
     * @ORM\Column(type="datetime")
     */
    private $ArriveAt;

    /**
     * @ORM\Column(type="integer")
     */
    private $price;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="locations")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Voiture", inversedBy="locations")
     */
    private $voiture;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Facture", mappedBy="location", cascade={"persist", "remove"})
     */
    private $facture;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isReturn;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Property", inversedBy="locations")
     */
    private $property;

    /**
     * @ORM\Column(type="integer", nullable=true)
     */
    private $avance;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateLocation(): ?\DateTimeInterface
    {
        return $this->dateLocation;
    }

    public function setDateLocation(\DateTimeInterface $dateLocation): self
    {
        $this->dateLocation = $dateLocation;

        return $this;
    }

    public function getDepartAt(): ?\DateTimeInterface
    {
        return $this->departAt;
    }

    public function setDepartAt(\DateTimeInterface $departAt): self
    {
        $this->departAt = $departAt;

        return $this;
    }

    public function getArriveAt(): ?\DateTimeInterface
    {
        return $this->ArriveAt;
    }

    public function setArriveAt(\DateTimeInterface $ArriveAt): self
    {
        $this->ArriveAt = $ArriveAt;

        return $this;
    }

    public function getPrice(): ?int
    {
        return $this->price;
    }

    public function setPrice(int $price): self
    {
        $this->price = $price;

        return $this;
    }

    public function getClient(): ?client
    {
        return $this->client;
    }

    public function setClient(?client $client): self
    {
        $this->client = $client;

        return $this;
    }

    public function getVoiture(): ?voiture
    {
        return $this->voiture;
    }

    public function setVoiture(?voiture $voiture): self
    {
        $this->voiture = $voiture;

        return $this;
    }

    public function getFacture(): ?Facture
    {
        return $this->facture;
    }

    public function setFacture(Facture $facture): self
    {
        $this->facture = $facture;

        // set the owning side of the relation if necessary
        if ($facture->getLocation() !== $this) {
            $facture->setLocation($this);
        }

        return $this;
    }

    public function getIsReturn(): ?bool
    {
        return $this->isReturn;
    }

    public function setIsReturn(bool $isReturn): self
    {
        $this->isReturn = $isReturn;

        return $this;
    }

    public function getProperty(): ?property
    {
        return $this->property;
    }

    public function setProperty(?property $property): self
    {
        $this->property = $property;

        return $this;
    }

    public function getAvance(): ?int
    {
        return $this->avance;
    }

    public function setAvance(?int $avance): self
    {
        $this->avance = $avance;

        return $this;
    }

}
