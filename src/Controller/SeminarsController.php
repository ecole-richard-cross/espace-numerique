<?php

namespace App\Controller;

use App\Entity\Seminar;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeminarsController extends AbstractController
{
    #[Route('/seminars', name: 'app_seminars_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $seminars = $em->getRepository(Seminar::class)->findPublishedByRoles($user->getRoles());
        $tags = $em->getRepository(Tag::class)->findAll();
        // Get all seminars
        return $this->render('seminars/index.html.twig', [
            'seminars' => $seminars,
            'tags' => $tags
        ]);
    }
}
