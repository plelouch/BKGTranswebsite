<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
use App\Entity\Property;
use App\Form\BookingType;
use App\Repository\BookingRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
class BookingController extends AbstractController
{
    /**
     * @Route("/booking", name="booking_index", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ad/{id}/booking", name="booking_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function new(Ad $ad, Request $request): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $booker = $this->getUser();
            $booking->setAd($ad)
                    ->setBooker($booker)
                    ->setConfirmation('En Attente...');
            if (!$booking->isBookableDays()){
                $this->addFlash('warning', "Vous ne pouvez pas faire de reservation sur cette date");
            }else{
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($booking);
                $entityManager->flush();

                return $this->redirectToRoute('booking_show',[
                    'id' => $booking->getId(),
                    'withAlert' => true
                ]);
            }

        }

        return $this->render('booking/new.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/property/{id}/booking", name="property_booking_new", methods={"GET","POST"})
     * @IsGranted("ROLE_USER")
     */
    public function newProperty(Property $property, Request $request): Response
    {
        $booking = new Booking();
        $form = $this->createForm(BookingType::class, $booking);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $booker = $this->getUser();
            $booking->setProperty($property)
                ->setBooker($booker)
                ->setConfirmation('En Attente...');
            if (!$booking->isBookableDays()){
                $this->addFlash('warning', "Vous ne pouvez pas faire de reservation sur cette date");
            }else{
                $entityManager = $this->getDoctrine()->getManager();
                $entityManager->persist($booking);
                $entityManager->flush();

                return $this->redirectToRoute('booking_show',[
                    'id' => $booking->getId(),
                    'withAlert' => true
                ]);
            }

        }

        return $this->render('booking/property/new.html.twig', [
            'property' => $property,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/booking/{id}", name="booking_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(Booking $booking): Response
    {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

}
