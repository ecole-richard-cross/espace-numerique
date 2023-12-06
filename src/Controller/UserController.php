<?php

namespace App\Controller;

use App\Entity\Discussion;
use App\Entity\SeminarConsultation;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserController extends AbstractController
{
    public function getLastReadLink(): Response
    {
        $result = array_reduce(
            $this
                ->getUser()
                ->getSeminarConsultations()
                ->toArray(),
            function ($out, $sc) {
                if ($out == null)
                    return $sc;
                if ($out->getLastConsultedAt() < $sc->getLastConsultedAt())
                    return $sc;
                else
                    return $out;
            },
            null
        );
        return $this->render('user/lastReadLink.html.twig', ['lastRead' => $result]);;
    }

    #[Route('/user/dashboard', name: 'app_user_dashboard')]
    public function index(EntityManagerInterface $em): Response
    {
        $currentReads = $em->getRepository(SeminarConsultation::class)->findBy(['user' => $this->getUser(), 'isFinished' => false]);
        $filteredCurrentReads = array_filter($currentReads, function ($read) {
            return count($read->getFinishedChapters());
        });
        $discuRepo = $em->getRepository(Discussion::class);
        $userQs = $discuRepo->findBy(['user' => $this->getUser()]);
        $last3 = $discuRepo->getLastThree();

        return $this->render('user_dashboard/index.html.twig', [
            'currentReads' => $filteredCurrentReads,
            'userQs' => $userQs,
            'last3' => $last3
        ]);
    }
}
