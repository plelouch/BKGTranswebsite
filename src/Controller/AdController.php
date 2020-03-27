<?php

namespace App\Controller;

use App\Entity\Ad;
use App\Entity\Rating;
use App\Form\AdType;
use App\Form\RatingType;
use App\Repository\AdRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("")
 */
class AdController extends AbstractController
{
    /**
     * @Route("/admin/ad", name="ad_index", methods={"GET"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function index(AdRepository $adRepository): Response
    {
        return $this->render('admin/ad/index.html.twig', [
            'ads' => $adRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ad/liste", name="ad_liste", methods={"GET"})
     */
    public function list(AdRepository $adRepository): Response
    {
        return $this->render('ad/index.html.twig', [
            'ads' => $adRepository->findAll(),
        ]);
    }

    /**
     * @Route("/admin/ad/new", name="ad_new", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function new(Request $request): Response
    {
        $ad = new Ad();
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($ad);
            $entityManager->flush();

            return $this->redirectToRoute('ad_index');
        }

        return $this->render('admin/ad/new.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ad/{id}", name="ad_show", methods={"GET","POST"})
     */
    public function show(Ad $ad, Request $request): Response
    {
        $rating = new Rating();
        $form = $this->createForm(RatingType::class, $rating);
        $form->handleRequest($request);
        if($form->isSubmitted() and $form->isValid()){
            $rating->setAd($ad)
                ->setAuthor($this->getUser());
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($rating);
            $entityManager->flush();

        }
        return $this->render('ad/show.html.twig', [
            'ad' => $ad,
            'form' => $form->createView()
        ]);
    }

    /**
     * @Route("/admin/ad/{id}/edit", name="ad_edit", methods={"GET","POST"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function edit(Request $request, Ad $ad): Response
    {
        $form = $this->createForm(AdType::class, $ad);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            return $this->redirectToRoute('ad_index');
        }

        return $this->render('admin/ad/edit.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/admin/ad/{id}", name="ad_delete", methods={"DELETE"})
     * @IsGranted("ROLE_ADMIN")
     */
    public function delete(Request $request, Ad $ad): Response
    {
        if ($this->isCsrfTokenValid('delete'.$ad->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($ad);
            $entityManager->flush();
        }

        return $this->redirectToRoute('ad_index');
    }
}
