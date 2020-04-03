<?php

namespace App\Controller;

use App\Entity\Facture;
use App\Entity\Sell;
use App\Form\SellPropertyType;
use App\Form\SellType;
use App\Repository\SellRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/admin", name="admin_")
 */
class SellController extends AbstractController
{
    /**
     * @Route("/sell", name="sell_index", methods={"GET"})
     */
    public function index(SellRepository $sellRepository): Response
    {
        return $this->render('admin/sell/index.html.twig', [
            'sells' => $sellRepository->findAll(),
        ]);
    }

    /**
     * @Route("/sell/new/car", name="sell_new_car", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $sell = new Sell();
        $facture = new Facture();
        $form = $this->createForm(SellType::class, $sell);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $facture->setDateAt(new \DateTime())
                ->setNumFacture(mt_rand(5000, 10000))
                ->setClient($sell->getClient());
            $sell->setFacture($facture);

            $entityManager->persist($sell);
            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('admin_sell_index');
        }

        return $this->render('admin/sell/new.html.twig', [
            'sell' => $sell,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/sell/new/property", name="sell_new_property", methods={"GET","POST"})
     */
    public function newProperty(Request $request): Response
    {
        $sell = new Sell();
        $facture = new Facture();
        $form = $this->createForm(SellPropertyType::class, $sell);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $facture->setDateAt(new \DateTime())
                ->setNumFacture(mt_rand(5000, 10000))
                ->setClient($sell->getClient());
            $sell->setFacture($facture);

            $entityManager->persist($sell);
            $entityManager->persist($facture);
            $entityManager->flush();

            return $this->redirectToRoute('admin_sell_index');
        }

        return $this->render('admin/sell/newProperty.html.twig', [
            'sell' => $sell,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/sell/{id}", name="sell_show", methods={"GET"})
     */
    public function show(Sell $sell): Response
    {
        return $this->render('admin/sell/show.html.twig', [
            'sell' => $sell,
        ]);
    }

    /**
     * @Route("/sell/{id}/edit/car", name="sell_edit_car", methods={"GET","POST"})
     */
    public function editCar(Request $request, Sell $sell): Response
    {
        $form = $this->createForm(SellType::class, $sell);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_sell_index', [
                'id' => $sell->getId(),
            ]);
        }

        return $this->render('admin/sell/edit.html.twig', [
            'sell' => $sell,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/sell/{id}/edit/property", name="sell_edit_property", methods={"GET","POST"})
     */
    public function editProperty(Request $request, Sell $sell): Response
    {
        $form = $this->createForm(SellPropertyType::class, $sell);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('admin_sell_index', [
                'id' => $sell->getId(),
            ]);
        }

        return $this->render('admin/sell/edit.html.twig', [
            'sell' => $sell,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/sell/{id}", name="sell_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Sell $sell): Response
    {
        if ($this->isCsrfTokenValid('delete'.$sell->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($sell);
            $entityManager->flush();
        }

        return $this->redirectToRoute('admin_sell_index');
    }

    /**
     * @Route("/valid/sell/{id}/property", name="valid_sell_property", methods={"GET"})
     */
    public function sellProperty(Sell $sell)
    {
        $property = $sell->getProperty();
        $property->setSold(true);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($property);
        $entityManager->flush();

        return $this->redirectToRoute("admin_sell_index");
    }

    /**
     * @Route("/valid/sell/{id}/car", name="valid_sell_car", methods={"GET"})
     */
    public function sellCar(Sell $sell)
    {
        $car = $sell->getCar();
        $car->setIsDispo(false);
        $entityManager = $this->getDoctrine()->getManager();
        $entityManager->persist($car);
        $entityManager->flush();

        return $this->redirectToRoute("admin_sell_index");
    }
}
