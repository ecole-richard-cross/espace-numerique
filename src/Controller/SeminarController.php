<?php

namespace App\Controller;

use App\Entity\Chapter;
use App\Entity\Seminar;
use App\Entity\SeminarConsultation;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/espace-seminaire')]
class SeminarController extends AbstractController
{
    #[Route('/lire/{id}/{chapterId}/{sectionId}', name: 'app_seminar_read_toSection')]
    public function section(Seminar $seminar, int $chapterId, int $sectionId, EntityManagerInterface $entityManager): Response
    {
        if (!$seminar->isIsPublished()) {
            $this->addFlash(
                'warning',
                'Cet article n\'est plus accessible.'
            );
            return $this->redirectToRoute('app_seminars_index');
        }

        $orderedChapters = $entityManager->getRepository(Chapter::class)->findBySeminarOrdered($seminar);
        $consult = $entityManager
            ->getRepository(SeminarConsultation::class)
            ->findOneBy(['seminar' => $seminar, 'user' => $this->getUser()]);
        $consult->setLastConsultedAtNow();

        $entityManager->persist($consult);
        $entityManager->flush();

        return $this->render('seminar/read.html.twig', [
            'seminar' => $seminar,
            'orderedChapters' => $orderedChapters,
            'chapterId' => $chapterId,
            'sectionId' => $sectionId,
            'finishedChapters' => $consult->getFinishedChapters()
        ]);
    }

    #[Route('/lire/{id}/{chapterId}', name: 'app_seminar_read')]
    public function chapter(Seminar $seminar, int $chapterId, EntityManagerInterface $entityManager): Response
    {
        if (!$seminar->isIsPublished()) {
            $this->addFlash(
                'warning',
                'Cet article n\'est plus accessible.'
            );
            return $this->redirectToRoute('app_seminars_index');
        }
        
        $orderedChapters = $entityManager->getRepository(Chapter::class)->findBySeminarOrdered($seminar);
        $consult = $entityManager
            ->getRepository(SeminarConsultation::class)
            ->findOneBy(['seminar' => $seminar, 'user' => $this->getUser()]);
        $consult->setLastConsultedAtNow();

        $entityManager->persist($consult);
        $entityManager->flush();

        return $this->render('seminar/read.html.twig', [
            'seminar' => $seminar,
            'orderedChapters' => $orderedChapters,
            'chapterId' => $chapterId,
            'finishedChapters' => $consult->getFinishedChapters()
        ]);
    }

    #[Route('/lire/{id}', name: 'app_seminar_intro')]
    public function read(Seminar $seminar, EntityManagerInterface $entityManager): Response
    {
        if (!$seminar->isIsPublished()) {
            $this->addFlash(
                'warning',
                'Cet article n\'est plus accessible.'
            );
            return $this->redirectToRoute('app_seminars_index');
        }
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

        return $this->render('seminar/read.html.twig', [
            'seminar' => $seminar,
            'finishedChapters' => $consult->getFinishedChapters()
        ]);
    }

    #[Route('/lu/{id}', 'app_seminar_mark')]
    public function userHasRead(Seminar $seminar, EntityManagerInterface $entityManager, Request $req): Response
    {
        $chapterId = $req->query->get('chapterId');

        $consult = $entityManager
            ->getRepository(SeminarConsultation::class)
            ->findOneBy(['seminar' => $seminar, 'user' => $this->getUser()]);

        if (!is_null($chapterId)) {
            // Mark chapter as read
            $consult->addFinishedChapter($chapterId);

            $entityManager->persist($consult);
            $entityManager->flush();
            // redirect to next chapter
            return $this->redirectToRoute('app_seminar_read', ['id' => $seminar->getId(), 'chapterId' => $chapterId + 1]);
        }
        // Mark last chapter and seminar as read
        $consult
            ->setLastConsultedAtNow()
            ->markAllChaptersRead()
            ->setIsToRead(false)
            ->setIsFinished(true);

        $this->addFlash(
            'success',
            '"' . $consult->getSeminar() . '" terminé !'
        );

        $entityManager->persist($consult);
        $entityManager->flush();
        // Redirect to seminars list
        return $this->redirectToRoute('app_seminars_index');
    }

    #[Route('/reinitialiser/{id}', 'app_seminar_reset')]
    public function resetProgression(Seminar $seminar, EntityManagerInterface $em): Response
    {
        $c = $seminar
            ->getConsultByUser($this->getUser());
        $c
            ->setIsFinished(false)
            ->setFinishedChapters([]);

        $em->persist($c);
        $em->flush();

        $this->addFlash('success', 'Votre progression dans "' . $c->getSeminar() . '" a été réinitialisée.');

        return $this->redirectToRoute('app_seminar_intro', ['id' => $seminar->getId()]);
    }

    #[Route('/liste', name: 'app_seminars_index')]
    public function index(EntityManagerInterface $em): Response
    {
        $user = $this->getUser();
        $seminars = $em->getRepository(Seminar::class)->findPublishedByRoles($user->getRoles());
        $tags = $em->getRepository(Tag::class)->findAll();
        // Get all seminars
        return $this->render('seminar/index.html.twig', [
            'seminars' => $seminars,
            'tags' => $tags
        ]);
    }
}
