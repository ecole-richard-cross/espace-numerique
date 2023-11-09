<?php

namespace App\Controller;

use App\Entity\CentreFormation;
use App\Form\CentreFormationType;
use App\Repository\CentreFormationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/centre/formation')]
class CentreFormationController extends AbstractController
{
    #[Route('/', name: 'app_centre_formation_index', methods: ['GET'])]
    public function index(CentreFormationRepository $centreFormationRepository): Response
    {
        return $this->render('centre_formation/index.html.twig', [
            'centre_formations' => $centreFormationRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_centre_formation_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $centreFormation = new CentreFormation();
        $form = $this->createForm(CentreFormationType::class, $centreFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($centreFormation);
            $entityManager->flush();

            return $this->redirectToRoute('app_centre_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('centre_formation/new.html.twig', [
            'centre_formation' => $centreFormation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_centre_formation_show', methods: ['GET'])]
    public function show(CentreFormation $centreFormation): Response
    {
        return $this->render('centre_formation/show.html.twig', [
            'centre_formation' => $centreFormation,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_centre_formation_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, CentreFormation $centreFormation, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(CentreFormationType::class, $centreFormation);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_centre_formation_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('centre_formation/edit.html.twig', [
            'centre_formation' => $centreFormation,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_centre_formation_delete', methods: ['POST'])]
    public function delete(Request $request, CentreFormation $centreFormation, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$centreFormation->getId(), $request->request->get('_token'))) {
            $entityManager->remove($centreFormation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_centre_formation_index', [], Response::HTTP_SEE_OTHER);
    }
}
