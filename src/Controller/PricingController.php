<?php

namespace App\Controller;

use App\Entity\Pricing;
use App\Form\PricingType;
use App\Repository\PricingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/pricing")
 */
class PricingController extends AbstractController
{
    /**
     * @Route("/", name="pricing_index", methods={"GET"})
     */
    public function index(PricingRepository $pricingRepository): Response
    {
        return $this->render('pricing/index.html.twig', [
            'pricings' => $pricingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/new", name="pricing_new", methods={"GET","POST"})
     */
    public function new(Request $request): Response
    {
        $pricing = new Pricing();
        $form = $this->createForm(PricingType::class, $pricing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($pricing);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Pricing added'
            );

            return $this->redirectToRoute('pricing_index');
        }

        return $this->render('pricing/new.html.twig', [
            'pricing' => $pricing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pricing_show", methods={"GET"})
     */
    public function show(Pricing $pricing): Response
    {
        return $this->render('pricing/show.html.twig', [
            'pricing' => $pricing,
        ]);
    }

    /**
     * @Route("/{id}/edit", name="pricing_edit", methods={"GET","POST"})
     */
    public function edit(Request $request, Pricing $pricing): Response
    {
        $form = $this->createForm(PricingType::class, $pricing);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->getDoctrine()->getManager()->flush();

            $this->addFlash(
                'success',
                'Pricing updated'
            );

            return $this->redirectToRoute('pricing_index');
        }

        return $this->render('pricing/edit.html.twig', [
            'pricing' => $pricing,
            'form' => $form->createView(),
        ]);
    }

    /**
     * @Route("/{id}", name="pricing_delete", methods={"DELETE"})
     */
    public function delete(Request $request, Pricing $pricing): Response
    {
        if ($this->isCsrfTokenValid('delete'.$pricing->getId(), $request->request->get('_token'))) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->remove($pricing);
            $entityManager->flush();

            $this->addFlash(
                'success',
                'Pricing deleted'
            );
        }

        return $this->redirectToRoute('pricing_index');
    }
}
