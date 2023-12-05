<?php

namespace App\Controller;

use App\Entity\Seminar;
use App\Entity\SeminarConsultation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SeminarReadController extends AbstractController
{
    public function GetAllSeminars(EntityManagerInterface $em): Response
    {
        $seminars = $em->getRepository(Seminar::class)->findAll();
        return $this->render('seminar/_menu_all_seminars.html.twig', [
            'seminars' => $seminars
        ]);
    }

    #[Route('/seminar-read/{id}/{chapterId}/{sectionId}', name: 'app_seminar_read_toSection')]
    public function section(int $id, int $chapterId, int $sectionId, EntityManagerInterface $entityManager): Response
    {
        $seminar = $entityManager->getRepository(Seminar::class)->findOneBy(['id' => $id]);
        $consult = $entityManager
            ->getRepository(SeminarConsultation::class)
            ->findOneBy(['seminar' => $seminar, 'user' => $this->getUser()]);
        $consult->setLastConsultedAtNow();

        $entityManager->persist($consult);
        $entityManager->flush();

        return $this->render('seminar/index.html.twig', [
            'seminar' => $seminar,
            'chapterId' => $chapterId,
            'sectionId' => $sectionId,
            'finishedChapters' => $consult->getFinishedChapters()
        ]);
    }

    #[Route('/seminar-read/{id}/{chapterId}', name: 'app_seminar_read')]
    public function chapter(int $id, int $chapterId, EntityManagerInterface $entityManager): Response
    {
        $seminar = $entityManager->getRepository(Seminar::class)->findOneBy(['id' => $id]);
        $consult = $entityManager
            ->getRepository(SeminarConsultation::class)
            ->findOneBy(['seminar' => $seminar, 'user' => $this->getUser()]);
        $consult->setLastConsultedAtNow();

        $entityManager->persist($consult);
        $entityManager->flush();

        return $this->render('seminar/index.html.twig', [
            'seminar' => $seminar,
            'chapterId' => $chapterId,
            'finishedChapters' => $consult->getFinishedChapters()
        ]);
    }

    #[Route('/seminar-read/{id}', name: 'app_seminar_index')]
    public function index(int $id, EntityManagerInterface $entityManager): Response
    {
        $seminar = $entityManager->getRepository(Seminar::class)->findOneBy(['id' => $id]);
        $consult = $entityManager
            ->getRepository(SeminarConsultation::class)
            ->findOneBy(['seminar' => $seminar, 'user' => $this->getUser()]);
        if ($consult == null) {
            $consult = new SeminarConsultation();
            $consult
                ->setSeminar($seminar)
                ->setUser($this->getUser());
        }
        $consult->setLastConsultedAtNow();

        $entityManager->persist($consult);
        $entityManager->flush();

        return $this->render('seminar/index.html.twig', [
            'seminar' => $seminar,
            'finishedChapters' => $consult->getFinishedChapters()
        ]);
    }

    #[Route('/seminar-mark-read/{id}', 'app_seminar_mark')]
    public function userHasRead(int $id, EntityManagerInterface $entityManager, Request $req): Response
    {
        $chapterId = $req->query->get('chapterId');

        $seminar = $entityManager->getRepository(Seminar::class)->findOneBy(['id' => $id]);
        $consult = $entityManager
            ->getRepository(SeminarConsultation::class)
            ->findOneBy(['seminar' => $seminar, 'user' => $this->getUser()]);

        if (!is_null($chapterId)) {
            // Mark chapter as read
            $consult->addFinishedChapter($chapterId);

            $entityManager->persist($consult);
            $entityManager->flush();
            // redirect to next chapter
            return $this->redirectToRoute('app_seminar_read', ['id' => $id, 'chapterId' => $chapterId + 1]);
        }
        // Mark last chapter and seminar as read
        $consult
            ->setLastConsultedAtNow()
            ->markAllChaptersRead()
            ->setIsToRead(false)
            ->setIsFinished(true);

        $entityManager->persist($consult);
        $entityManager->flush();
        // Redirect to seminars list
        return $this->redirectToRoute('app_seminars_index');
    }
}
