<?php

namespace App\Controller;

use App\Entity\PassageCertification;
use App\Form\PassageCertificationType;
use App\Repository\PassageCertificationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/passageCertification')]
class PassageCertificationController extends AbstractController
{
    #[Route('/', name: 'app_passage_certification_index', methods: ['GET'])]
    public function index(PassageCertificationRepository $passageCertificationRepository): Response
    {
        return $this->render('passage_certification/index.html.twig', [
            'passage_certifications' => $passageCertificationRepository->findAll(),
        ]);
    }


    #[Route('/new', name: 'app_passage_certification_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $passageCertification = new PassageCertification();
        $form = $this->createForm(PassageCertificationType::class, $passageCertification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($passageCertification);
            $entityManager->flush();

            return $this->redirectToRoute('app_passage_certification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('passage_certification/new.html.twig', [
            'passage_certification' => $passageCertification,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_passage_certification_show', methods: ['GET'])]
    public function show(PassageCertification $passageCertification): Response
    {
        return $this->render('passage_certification/show.html.twig', [
            'passage_certification' => $passageCertification,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_passage_certification_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PassageCertification $passageCertification, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PassageCertificationType::class, $passageCertification);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_passage_certification_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('passage_certification/edit.html.twig', [
            'passage_certification' => $passageCertification,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_passage_certification_delete', methods: ['POST'])]
    public function delete(Request $request, PassageCertification $passageCertification, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete' . $passageCertification->getId(), $request->request->get('_token'))) {
            $entityManager->remove($passageCertification);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_passage_certification_index', [], Response::HTTP_SEE_OTHER);
    }
}
