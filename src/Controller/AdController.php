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
     * @Route("/ad", name="ad_index", methods={"GET"})
     */
    public function index(AdRepository $adRepository): Response
    {
        return $this->render('ad/index.html.twig', [
            'ads' => $adRepository->findAll(),
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


}
