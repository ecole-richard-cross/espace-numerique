<?php

namespace App\Controller;

use App\Entity\Seminar;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeminarReadController extends AbstractController
{

    #[Route('/seminar_read/{id}/{chapterId}/{sectionId}', name: 'app_seminar_read_toSection')]
    public function section(int $id, int $chapterId, int $sectionId, EntityManagerInterface $entityManager): Response
    {
        $seminar = $entityManager->getRepository(Seminar::class)->findOneBy(['id' => $id]);
        return $this->render('seminar/index.html.twig', [
            'seminar' => $seminar,
            'chapterId' => $chapterId,
            'sectionId' => $sectionId
        ]);
    }

    #[Route('/seminar_read/{id}/{chapterId}', name: 'app_seminar_read')]
    public function chapter(int $id, int $chapterId, EntityManagerInterface $entityManager): Response
    {
        $seminar = $entityManager->getRepository(Seminar::class)->findOneBy(['id' => $id]);
        return $this->render('seminar/index.html.twig', [
            'seminar' => $seminar,
            'chapterId' => $chapterId
        ]);
    }

    #[Route('/seminar_read/{id}', name: 'app_seminar_index')]
    public function index(int $id, EntityManagerInterface $entityManager): Response
    {
        $seminar = $entityManager->getRepository(Seminar::class)->findOneBy(['id' => $id]);
        return $this->render('seminar/index.html.twig', [
            'seminar' => $seminar
        ]);
    }

    public function GetAllSeminars(EntityManagerInterface $em): Response
    {
        $seminars = $em->getRepository(Seminar::class)->findAll();
        return $this->render('seminar/_menu_all_seminars.html.twig', [
            'seminars' => $seminars
        ]);
    }
}
