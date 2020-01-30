<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    /**
     * @Route("/admin", name="admin")
     * @return Response
     */
    public function adminPage(): Response
    {
        return $this->render('admin.html.twig');
    }
}


