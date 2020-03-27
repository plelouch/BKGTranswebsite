<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\FactureRepository")
 */
class Facture
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="integer")
     */
    private $numFacture;

    /**
     * @ORM\Column(type="datetime")
     */
    private $dateAt;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="factures")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\Location", inversedBy="facture", cascade={"persist", "remove"})
     * @ORM\JoinColumn(nullable=false)
     */
    private $location;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumFacture(): ?int
    {
        return $this->numFacture;
    }

    public function setNumFacture(int $numFacture): self
    {
        $this->numFacture = $numFacture;

        return $this;
    }

    public function getDateAt(): ?\DateTimeInterface
    {
        return $this->dateAt;
    }

    public function setDateAt(\DateTimeInterface $dateAt): self
    {
        $this->dateAt = $dateAt;

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

    public function getLocation(): ?location
    {
        return $this->location;
    }

    public function setLocation(location $location): self
    {
        $this->location = $location;

        return $this;
    }
}
