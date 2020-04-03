<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VoitureRepository")
 * @UniqueEntity(fields={"matricule"}, message="Ce numéros de matricule existe déjà")
 */
class Voiture
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
    private $matricule;

    /**
     * @ORM\Column(type="date")
     */
    private $dateDrive;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $modele;

    /**
     * @ORM\Column(type="integer")
     */
    private $compteur;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $marque;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $couleur;

    /**
     * @ORM\Column(type="boolean")
     */
    private $isDispo;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Location", mappedBy="voiture", orphanRemoval=true)
     */
    private $locations;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $image;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Infosup", mappedBy="voiture", orphanRemoval=true, cascade={"persist"})
     * @Assert\Valid()
     */
    private $infosups;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Ad", mappedBy="voiture", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $ads;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Type", inversedBy="voiture")
     * @ORM\JoinColumn(nullable=false)
     */
    private $type;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Sell", mappedBy="car")
     */
    private $sells;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->infosups = new ArrayCollection();
        $this->ads = new ArrayCollection();
        $this->sells = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getMatricule(): ?int
    {
        return $this->matricule;
    }

    public function setMatricule(int $matricule): self
    {
        $this->matricule = $matricule;

        return $this;
    }

    public function getDateDrive(): ?\DateTimeInterface
    {
        return $this->dateDrive;
    }

    public function setDateDrive(\DateTimeInterface $dateDrive): self
    {
        $this->dateDrive = $dateDrive;

        return $this;
    }

    public function getModele(): ?string
    {
        return $this->modele;
    }

    public function setModele(string $modele): self
    {
        $this->modele = $modele;

        return $this;
    }

    public function getCompteur(): ?int
    {
        return $this->compteur;
    }

    public function setCompteur(int $compteur): self
    {
        $this->compteur = $compteur;

        return $this;
    }

    public function getMarque(): ?string
    {
        return $this->marque;
    }

    public function setMarque(string $marque): self
    {
        $this->marque = $marque;

        return $this;
    }

    public function getCouleur(): ?string
    {
        return $this->couleur;
    }

    public function setCouleur(string $couleur): self
    {
        $this->couleur = $couleur;

        return $this;
    }

    public function getIsDispo(): ?bool
    {
        return $this->isDispo;
    }

    public function setIsDispo(bool $isDispo): self
    {
        $this->isDispo = $isDispo;

        return $this;
    }

    /**
     * @return Collection|Location[]
     */
    public function getLocations(): Collection
    {
        return $this->locations;
    }

    public function addLocation(Location $location): self
    {
        if (!$this->locations->contains($location)) {
            $this->locations[] = $location;
            $location->setVoiture($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
            // set the owning side to null (unless already changed)
            if ($location->getVoiture() === $this) {
                $location->setVoiture(null);
            }
        }

        return $this;
    }

    public function getImage(): ?string
    {
        return $this->image;
    }

    public function setImage(?string $image): self
    {
        $this->image = $image;

        return $this;
    }

    /**
     * @return Collection|Infosup[]
     */
    public function getInfosups(): Collection
    {
        return $this->infosups;
    }

    public function addInfosup(Infosup $infosup): self
    {
        if (!$this->infosups->contains($infosup)) {
            $this->infosups[] = $infosup;
            $infosup->setVoiture($this);
        }

        return $this;
    }

    public function removeInfosup(Infosup $infosup): self
    {
        if ($this->infosups->contains($infosup)) {
            $this->infosups->removeElement($infosup);
            // set the owning side to null (unless already changed)
            if ($infosup->getVoiture() === $this) {
                $infosup->setVoiture(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Ad[]
     */
    public function getAds(): Collection
    {
        return $this->ads;
    }

    public function addAd(Ad $ad): self
    {
        if (!$this->ads->contains($ad)) {
            $this->ads[] = $ad;
            $ad->setVoiture($this);
        }

        return $this;
    }

    public function removeAd(Ad $ad): self
    {
        if ($this->ads->contains($ad)) {
            $this->ads->removeElement($ad);
            // set the owning side to null (unless already changed)
            if ($ad->getVoiture() === $this) {
                $ad->setVoiture(null);
            }
        }

        return $this;
    }

    public function getType(): ?Type
    {
        return $this->type;
    }

    public function setType(?Type $type): self
    {
        $this->type = $type;

        return $this;
    }

    /**
     * @return Collection|Sell[]
     */
    public function getSells(): Collection
    {
        return $this->sells;
    }

    public function addSell(Sell $sell): self
    {
        if (!$this->sells->contains($sell)) {
            $this->sells[] = $sell;
            $sell->setCar($this);
        }

        return $this;
    }

    public function removeSell(Sell $sell): self
    {
        if ($this->sells->contains($sell)) {
            $this->sells->removeElement($sell);
            // set the owning side to null (unless already changed)
            if ($sell->getCar() === $this) {
                $sell->setCar(null);
            }
        }

        return $this;
    }

}
