<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{

    #[Route('/bienvenue', name: 'app_welcome')]
    public function welcome(): Response
    {
        return $this->render('index/welcome.html.twig');
    }

    #[Route('/', name: 'app_index')]
    public function index(): Response
    {
        if (!$this->isGranted('ROLE_USER'))
            return $this->redirectToRoute('app_welcome');
        return $this->redirectToRoute('app_user_dashboard');
    }
}
