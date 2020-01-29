<?php

namespace App\Controller;

use App\Entity\Performance;
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
}
