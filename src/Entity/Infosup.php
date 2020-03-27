<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\InfosupRepository")
 */
class Infosup
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
    private $dateVidDep;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="dateVidDep", message="La date de départ doivent être plus élogner que la date d'arrivée !")
     */
    private $dateVidFin;

    /**
     * @ORM\Column(type="date")
     */
    private $dateChanRouDep;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="dateChanRouDep", message="La date de départ doivent être plus élogner que la date d'arrivée !")
     */
    private $dateChanRouFin;

    /**
     * @ORM\Column(type="date")
     */
    private $dateVisTechDep;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="dateVisTechDep", message="La date de départ doivent être plus élogner que la date d'arrivée !")
     */
    private $dateVisTechFin;

    /**
     * @ORM\Column(type="date")
     */
    private $dateAssurDep;

    /**
     * @ORM\Column(type="date")
     * @Assert\GreaterThan(propertyPath="dateAssurDep", message="La date de départ doivent être plus élogner que la date d'arrivée !")
     */
    private $dateAssurFin;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\voiture", inversedBy="infosups")
     * @ORM\JoinColumn(nullable=false)
     */
    private $voiture;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDateVidDep(): ?\DateTimeInterface
    {
        return $this->dateVidDep;
    }

    public function setDateVidDep(\DateTimeInterface $dateVidDep): self
    {
        $this->dateVidDep = $dateVidDep;

        return $this;
    }

    public function getDateVidFin(): ?\DateTimeInterface
    {
        return $this->dateVidFin;
    }

    public function setDateVidFin(\DateTimeInterface $dateVidFin): self
    {
        $this->dateVidFin = $dateVidFin;

        return $this;
    }

    public function getDateChanRouDep(): ?\DateTimeInterface
    {
        return $this->dateChanRouDep;
    }

    public function setDateChanRouDep(\DateTimeInterface $dateChanRouDep): self
    {
        $this->dateChanRouDep = $dateChanRouDep;

        return $this;
    }

    public function getDateChanRouFin(): ?\DateTimeInterface
    {
        return $this->dateChanRouFin;
    }

    public function setDateChanRouFin(\DateTimeInterface $dateChanRouFin): self
    {
        $this->dateChanRouFin = $dateChanRouFin;

        return $this;
    }

    public function getDateVisTechDep(): ?\DateTimeInterface
    {
        return $this->dateVisTechDep;
    }

    public function setDateVisTechDep(\DateTimeInterface $dateVisTechDep): self
    {
        $this->dateVisTechDep = $dateVisTechDep;

        return $this;
    }

    public function getDateVisTechFin(): ?\DateTimeInterface
    {
        return $this->dateVisTechFin;
    }

    public function setDateVisTechFin(\DateTimeInterface $dateVisTechFin): self
    {
        $this->dateVisTechFin = $dateVisTechFin;

        return $this;
    }

    public function getDateAssurDep(): ?\DateTimeInterface
    {
        return $this->dateAssurDep;
    }

    public function setDateAssurDep(\DateTimeInterface $dateAssurDep): self
    {
        $this->dateAssurDep = $dateAssurDep;

        return $this;
    }

    public function getDateAssurFin(): ?\DateTimeInterface
    {
        return $this->dateAssurFin;
    }

    public function setDateAssurFin(\DateTimeInterface $dateAssurFin): self
    {
        $this->dateAssurFin = $dateAssurFin;

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
}
