<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Facture;
use App\Repository\FactureRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class FactureController extends AbstractController
{
    /**
     * @Route("/admin/facture", name="facture_index")
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(FactureRepository $repository)
    {
        return $this->render('admin/facture/index.html.twig', [
            'factures' => $repository->findAll(),
        ]);
    }

    /**
     * @Route("/profile/client/{id}/facture", name="facture_user")
     * @IsGranted("ROLE_USER")
     */
    public function facture( Client $client, FactureRepository $repository)
    {
        return $this->render('facture/list.html.twig', [
            'factures' => $repository->findByUserFacture($client),
            'client' => $client
        ]);
    }

    /**
     * @Route("/admin/facture/{id}", name="facture_show")
     * @IsGranted("ROLE_ADMIN")
     */
    public function show(Facture $facture)
    {
        $location = $facture->getLocation();
        $voiture = $location->getVoiture();
        return $this->render('admin/facture/show.html.twig', [
            'facture' => $facture,
            'location' => $location,
            'voiture' => $voiture,
        ]);
    }
    /**
     * @Route("/user/facture/{id}", name="facture_user_show")
     * @IsGranted("ROLE_USER")
     */
    public function userShow(Facture $facture)
    {
        $location = $facture->getLocation();
        $voiture = $location->getVoiture();
        return $this->render('facture/facture.html.twig', [
            'facture' => $facture,
            'location' => $location,
            'voiture' => $voiture,
        ]);
    }
}
