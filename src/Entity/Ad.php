<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdRepository")
 */
class Ad
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
    private $title;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $introduction;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="float")
     */
    private $price;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Booking", mappedBy="ad", cascade={"persist", "remove"}, orphanRemoval=true)
     */
    private $bookings;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Voiture", inversedBy="ads")
     * @ORM\JoinColumn(nullable=false)
     */
    private $voiture;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Rating", mappedBy="ad", orphanRemoval=true)
     */
    private $ratings;

    public function __construct()
    {
        $this->bookings = new ArrayCollection();
        $this->ratings = new ArrayCollection();
    }

    /**
     * @param User $user
     * @return null
     */
    public function ratingUser(User $user)
    {
        foreach($this->ratings as $rating){
            if($rating->getAuthor() === $user){
                return $rating;
            }
        }
        return null;
    }

    /**
     * @return float|int
     */
    public function getAvgRatings()
    {
        // calcul de la somme des notation
        $sum = array_reduce($this->ratings->toArray(),function($total, $note){
            return $total + $note->getRating();
        },0);
        // moyenne des notation
        if(count($this->ratings) > 0) return $sum / count($this->ratings);

        return 0;
    }

    /**
     * @return array
     */
    public function getNotAvailableDays()
    {
        $notAvailableDays = [];
        foreach ($this->bookings as $booking){
            $resultat = range(
               $booking->getStartDate()->getTimestamp(),
               $booking->getEndDate()->getTimestamp(),
               24 * 60 * 60
            );
            $days = array_map(function ($dayTimestamp){
                return new  \DateTime(date('Y-m-d', $dayTimestamp));
            },$resultat);

            $notAvailableDays = array_merge($notAvailableDays, $days);
        }
        return $notAvailableDays;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTitle(): ?string
    {
        return $this->title;
    }

    public function setTitle(string $title): self
    {
        $this->title = $title;

        return $this;
    }

    public function getIntroduction(): ?string
    {
        return $this->introduction;
    }

    public function setIntroduction(string $introduction): self
    {
        $this->introduction = $introduction;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice(): ?float
    {
        return $this->price;
    }

    public function setPrice(float $price): self
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return Collection|Booking[]
     */
    public function getBookings(): Collection
    {
        return $this->bookings;
    }

    public function addBooking(Booking $booking): self
    {
        if (!$this->bookings->contains($booking)) {
            $this->bookings[] = $booking;
            $booking->setAd($this);
        }

        return $this;
    }

    public function removeBooking(Booking $booking): self
    {
        if ($this->bookings->contains($booking)) {
            $this->bookings->removeElement($booking);
            // set the owning side to null (unless already changed)
            if ($booking->getAd() === $this) {
                $booking->setAd(null);
            }
        }

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

    /**
     * @return Collection|Rating[]
     */
    public function getRatings(): Collection
    {
        return $this->ratings;
    }

    public function addRating(Rating $rating): self
    {
        if (!$this->ratings->contains($rating)) {
            $this->ratings[] = $rating;
            $rating->setAd($this);
        }

        return $this;
    }

    public function removeRating(Rating $rating): self
    {
        if ($this->ratings->contains($rating)) {
            $this->ratings->removeElement($rating);
            // set the owning side to null (unless already changed)
            if ($rating->getAd() === $this) {
                $rating->setAd(null);
            }
        }

        return $this;
    }
}
