<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Location;
use App\Entity\Retour;
use App\Form\LocationType;
use App\Repository\LocationRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin/location")
 * @IsGranted("ROLE_ADMIN")
 */
class LocationController extends AbstractController
{
    /**
     * @Route("/", name="location_index", methods={"GET"})
     */
    public function index(LocationRepository $locationRepository): Response
    {
        return $this->render('admin/location/index.html.twig', [
            'locations' => $locationRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="location_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $location = new Location();
        $facture = new Facture();
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $location->setDepartAt(new \DateTime())
                    ->setIsReturn(false)
            ;
            $voiture = $location->getVoiture();
            $voiture->setIsDispo(false);
            $facture->setClient($location->getClient())
                ->setDateAt(new \DateTime())
                ->setNumFacture(mt_rand(5000, 10000))
                ->setLocation($location)
            ;

            $entityManager->persist($location);
            $entityManager->persist($facture);
            $entityManager->persist($voiture);
            $entityManager->flush();

            return $this->redirectToRoute('location_index');
        }

        return $this->render('admin/location/new.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="location_show", methods={"GET"})
     */
    public function show(Location $location): Response
    {
        return $this->render('admin/location/show.html.twig', [
            'location' => $location,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="location_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Location $location): Response
    {
        $form = $this->createForm(LocationType::class, $location);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('location_index');
        }

        return $this->render('admin/location/edit.html.twig', [
            'location' => $location,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}/return", name="location_return")
     */
    public function retour(Location $location)
    {
        $location->setArriveAt(new \DateTime())
                ->setIsReturn(true);
        $voiture = $location->getVoiture();
        $voiture->setIsDispo(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($location);
        $entityManager->persist($voiture);
        $entityManager->flush();
        return $this->redirectToRoute('location_index');
    }

    /**
     * @Route("/{id}", name="location_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Location $location): Response
    {
        if ($this->isCsrfTokenValid('delete'.$location->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($location);
            $entityManager->flush();
        }

        return $this->redirectToRoute('location_index');
    }
}
