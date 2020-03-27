<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 */
class Client
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[a-z]+$/i",htmlPattern="^[a-zA-Z]+$")
     * @Assert\Length(min="3")
     */
    private $nom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[a-z]+$/i",htmlPattern="^[a-zA-Z]+$")
     * @Assert\Length(min="3")
     */
    private $prenom;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     */
    private $adresse;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[0-9]+$/i",htmlPattern="^[0-9]+$")
     * @Assert\Length(max="11")
     */
    private $numCin;

    /**
     * @ORM\Column(type="date")
     * @Assert\NotBlank()
     */
    private $dateNaiss;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[a-z]+$/i",htmlPattern="^[a-zA-Z]+$")
     * @Assert\Length(min="3")
     */
    private $lieuNaiss;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[0-9]+$/i",htmlPattern="^[0-9]+$")
     * @Assert\Length(max="11")
     */
    private $contact;

    /**
     * @ORM\Column(type="integer")
     * @Assert\NotBlank()
     * @Assert\Regex(pattern="/^[0-9]+$/i",htmlPattern="^[0-9]+$")
     * @Assert\Length(max="11")
     */
    private $numPermis;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Location", mappedBy="client", orphanRemoval=true)
     */
    private $locations;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Facture", mappedBy="client", orphanRemoval=true)
     */
    private $factures;

    /**
     * @ORM\OneToOne(targetEntity="App\Entity\User", inversedBy="client", cascade={"persist", "remove"})
     */
    private $user;

    public function __construct()
    {
        $this->locations = new ArrayCollection();
        $this->factures = new ArrayCollection();
    }

    public function getFullName()
    {
        return "{$this->nom} {$this->prenom}";
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrenom(): ?string
    {
        return $this->prenom;
    }

    public function setPrenom(string $prenom): self
    {
        $this->prenom = $prenom;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getNumCin(): ?int
    {
        return $this->numCin;
    }

    public function setNumCin(int $numCin): self
    {
        $this->numCin = $numCin;

        return $this;
    }

    public function getDateNaiss(): ?\DateTimeInterface
    {
        return $this->dateNaiss;
    }

    public function setDateNaiss(\DateTimeInterface $dateNaiss): self
    {
        $this->dateNaiss = $dateNaiss;

        return $this;
    }

    public function getLieuNaiss(): ?string
    {
        return $this->lieuNaiss;
    }

    public function setLieuNaiss(string $lieuNaiss): self
    {
        $this->lieuNaiss = $lieuNaiss;

        return $this;
    }

    public function getContact(): ?int
    {
        return $this->contact;
    }

    public function setContact(int $contact): self
    {
        $this->contact = $contact;

        return $this;
    }

    public function getNumPermis(): ?int
    {
        return $this->numPermis;
    }

    public function setNumPermis(int $numPermis): self
    {
        $this->numPermis = $numPermis;

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
            $location->setClient($this);
        }

        return $this;
    }

    public function removeLocation(Location $location): self
    {
        if ($this->locations->contains($location)) {
            $this->locations->removeElement($location);
            // set the owning side to null (unless already changed)
            if ($location->getClient() === $this) {
                $location->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Facture[]
     */
    public function getFactures(): Collection
    {
        return $this->factures;
    }

    public function addFacture(Facture $facture): self
    {
        if (!$this->factures->contains($facture)) {
            $this->factures[] = $facture;
            $facture->setClient($this);
        }

        return $this;
    }

    public function removeFacture(Facture $facture): self
    {
        if ($this->factures->contains($facture)) {
            $this->factures->removeElement($facture);
            // set the owning side to null (unless already changed)
            if ($facture->getClient() === $this) {
                $facture->setClient(null);
            }
        }

        return $this;
    }

    public function getUser(): ?user
    {
        return $this->user;
    }

    public function setUser(?user $user): self
    {
        $this->user = $user;

        return $this;
    }
}
