<?php


namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DefautController extends AbstractController
{
    /**
     * @Route("/", name="app_index")
     */
    public function index(): Response
    {
        return $this->render('home.html.twig');
    }

}




class MainController extends AbstractController
{
    /**
     * @Route("/main", name="main_index")
     */
    public function index(): Response
    {
        return $this->render('main/index.html.twig', [
            'website' => 'Wild Séries',
        ]);
    }
}