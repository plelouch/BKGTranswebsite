<?php
namespace App\Controller\admin;

use App\Entity\Booking;
use App\Repository\BookingRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class BookingController
 * @package App\Controller\admin
 * @Route("/admin", name="admin_")
 * @IsGranted("ROLE_ADMIN")
 */
class BookingController extends AbstractController
{

    /**
     * @Route("/booking", name="booking_index", methods={"GET","POST"})
     */
    public function index(BookingRepository $bookingRepository): Response
    {
        return $this->render('admin/booking/index.html.twig', [
            'bookings' => $bookingRepository->findAll(),
        ]);
    }


    /**
     * @Route("/booking/{id}", name="booking_delete", methods={"DELETE"})
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
     * @Route("/booking/{id}/valide", name="booking_valide", methods={"GET","POST"})
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
     * @Route("/booking/{id}/notvalide", name="booking_notvalide", methods={"GET","POST"})
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
     * @Route("/booking/{id}", name="booking_show")
     */
    public function show(Booking $booking)
    {
        return $this->render('admin/booking/show.html.twig', [
            'booking' => $booking,
        ]);
    }

}