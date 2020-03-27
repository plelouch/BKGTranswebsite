<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Booking;
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
     * @Route("/booking/{id}", name="booking_show", methods={"GET"})
     * @IsGranted("ROLE_USER")
     */
    public function show(Booking $booking): Response
    {
        return $this->render('booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

    /**
     * @Route("/admin/booking/list", name="booking_list", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function list(BookingRepository $bookingRepository): Response
    {
        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/booking/{id}", name="booking_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Booking $booking): Response
    {
        if ($this->isCsrfTokenValid('delete'.$booking->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($booking);
            $entityManager->flush();
        }

        return $this->redirectToRoute('booking_index');
    }

    /**
     * @Route("/admin/booking/{id}/valide", name="booking_valide", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function valide(Booking $booking): Response
    {
        $booking->setConfirmation('Accepter');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($booking);
        $entityManager->flush();
        return $this->redirectToRoute('booking_list');
    }
    /**
     * @Route("/admin/booking/{id}/notvalide", name="booking_notvalide", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function notValide(Booking $booking): Response
    {
        $booking->setConfirmation('Réfuser');
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($booking);
        $entityManager->flush();
        return $this->redirectToRoute('booking_list');
    }

    /**
     * @Route("/admin/booking/{id}", name="admin_booking_show")
     * @IsGranted("ROLE_ADMIN")
     */
    public function adminShow(Booking $booking)
    {
        return $this->render('booking/admin/show.html.twig', [
            'booking' => $booking,
        ]);
    }
}
