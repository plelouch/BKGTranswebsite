<?php

namespace App\Controller;

use App\Repository\AdRepository;
use App\Repository\BookingRepository;
use App\Repository\ClientRepository;
use App\Repository\FactureRepository;
use App\Repository\LocationRepository;
use App\Repository\PropertyRepository;
use App\Repository\VoitureRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="homepage")
     */
    public function index(AdRepository $adRepository, PropertyRepository $property)
    {
        return $this->render('home/index.html.twig', [
            'ads' => $adRepository->findByBookingCount(),
            'properties' => $property->findBy6BestProperty()
        ]);
    }

    /**
     * @Route("/contact", name="contactpage")
     */
    public function contact()
    {
        return $this->render('home/contact.html.twig', [
            'controller_name' => 'HomeController',
        ]);
    }

    /**
     * @Route("/admin", name="homeadmin")
     * @IsGranted("ROLE_ADMIN")
     */
    public function dashbord(BookingRepository $bookingRepository, ClientRepository $clientRepository, VoitureRepository $voitureRepository, LocationRepository $locationRepository, FactureRepository $factureRepository)
    {
        return $this->render('admin/home/index.html.twig', [
            'locations' => $locationRepository->findAll(),
            'voitureDispo' => $voitureRepository->findByVoitureIsDispo(),
            'clients' => $clientRepository->findAll(),
            'client' => $clientRepository->count([]),
            'voiture' => $voitureRepository->count([]),
            'location' => $locationRepository->count([]),
            'booking' => $bookingRepository->count([])
        ]);
    }
}
