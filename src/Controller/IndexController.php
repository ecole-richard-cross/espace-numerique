<?php

namespace App\Controller;

use App\Entity\Seminar;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
    #[Route('/', name: 'app_index')]
    public function index(EntityManagerInterface $entityManager): Response
    {
        dump($this->getUser());
        if ($this->getUser() == null)
            return $this->redirectToRoute('app_login');

        $seminars = $entityManager->getRepository(Seminar::class)->findAll();
        return $this->render('index/index.html.twig', [
            'seminars' => $seminars
        ]);
    }
}
