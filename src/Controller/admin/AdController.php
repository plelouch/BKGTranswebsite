<?php


namespace App\Controller\admin;


use App\Entity\Ad;
use App\Form\AdType;
use App\Repository\AdRepository;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * Class AdController
 * @package App\Controller\admin
 * @Route("/admin", name="admin_")
 * @IsGranted("ROLE_ADMIN")
 */
class AdController extends AbstractController
{
    /**
     * @Route("/ad", name="ad_index", methods={"GET"})
     */
    public function index(AdRepository $adRepository): Response
    {
        return $this->render('admin/ad/index.html.twig', [
            'ads' => $adRepository->findAll(),
        ]);
    }

    /**
     * @Route("/ad/new", name="ad_new", methods={"GET","POST"})
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

            return $this->redirectToRoute('admin_ad_index');
        }

        return $this->render('admin/ad/new.html.twig', [
            'ad' => $ad,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/ad/{id}", name="ad_show", methods={"GET"})
     */
    public function show(Ad $ad): Response
    {
        return $this->render('ad/show.html.twig', [
            'ad' => $ad,
        ]);
    }

    /**
     * @Route("/ad/{id}/edit", name="ad_edit", methods={"GET","POST"})
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
     * @Route("/ad/{id}", name="ad_delete", methods={"DELETE"})
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