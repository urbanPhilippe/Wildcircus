<?php

namespace App\Controller;

use App\Entity\Performance;
use App\Form\ContactType;
use Symfony\Component\HttpFoundation\Request;
use App\Entity\Pricing;
use App\Entity\Contact;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Email;
use App\Repository\ContactRepository;
use App\Repository\PricingRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

/**
 * @Route("/wild", name="wild")
 */

class WildController extends AbstractController
{
    /**
     * @Route("/", name="_index")
     */
    public function index()
    {
        return $this->render('wild/index.html.twig', [
            'controller_name' => 'WildController',
        ]);
    }

    /**
     * Show all rows from Performance’s entity
     *
     * @Route("/performance", name="_performance")
     */
    public function showPerformance(): Response
    {
        $performance = $this->getDoctrine()
            ->getRepository(Performance::class)
            ->findAll();
        if (!$performance) {
            throw $this->createNotFoundException(
                'No program found in performance\'s table.'
            );
        }
        return $this->render(
            'wild/performance.html.twig',
            ['performance' => $performance]
        );
    }
    /**
     * @Route("/pricing", name="_pricing", methods={"GET"})
     */
    public function showPricing(PricingRepository $pricingRepository): Response
    {
        return $this->render('wild/pricing.html.twig', [
            'pricings' => $pricingRepository->findAll(),
        ]);
    }

    /**
     * @Route("/contact", name="_contact", methods={"GET","POST"})
     *
     */
    public function showContact(Request $request,ContactRepository $contactRepository, MailerInterface $mailer): Response
    {
        $contact = new Contact();
        $form = $this->createForm(ContactType::class, $contact);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($contact);
            $entityManager->flush();

            $email = (new Email())
                ->from($this->getParameter('mailer_from'))
                ->to($form->getData()->getMail())
                ->subject('Nous avons bien reçu votre message')
                ->html($this->renderView('wild/notification.html.twig', [
                    'contact' => $contact,
                ]));
            $mailer->send($email);
            return $this->redirectToRoute('wild_contact');
        }

        return $this->render('wild/contact.html.twig', [
            'contact' => $contact,
            'form' => $form->createView(),
        ]);
    }

}
