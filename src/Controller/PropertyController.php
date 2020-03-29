<?php

namespace App\Controller;

use App\Entity\Property;
use App\Entity\Rating;
use App\Form\RatingType;
use App\Repository\PropertyRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("")
 */
class PropertyController extends AbstractController
{
    /**
     * @Route("/property", name="property_index", methods={"GET"})
     */
    public function index(PropertyRepository $propertyRepository): Response
    {
        return $this->render('property/index.html.twig', [
            'properties' => $propertyRepository->findAll(),
        ]);
    }

    /**
 * @Route("/property/{id}", name="property_show", methods={"GET", "POST"})
 */
    public function show(Property $property, Request $request): Response
    {
        $rating = new Rating();
        $form = $this->createForm(RatingType::class, $rating);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $rating->setProperty($property)
                ->setAuthor($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rating);
            $entityManager->flush();

        }
        return $this->render('property/show.html.twig', [
            'property' => $property,
            'form' => $form->createView()
        ]);
    }
}
