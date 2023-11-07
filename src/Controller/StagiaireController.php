<?php

namespace App\Controller;

use App\Entity\Stagiaire;
use App\Form\StagiaireType;
use App\Repository\StagiaireRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/stagiaire')]
class StagiaireController extends AbstractController
{
    #[Route('/', name: 'app_stagiaire_index', methods: ['GET'])]
    public function index(StagiaireRepository $stagiaireRepository): Response
    {
        return $this->render('stagiaire/index.html.twig', [
            'stagiaires' => $stagiaireRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_stagiaire_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $stagiaire = new Stagiaire();
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $stagiaire->setReseaux(getSortedReseaux($form));
            $stagiaire->setLocalisation(getLocalisation($form));
            $entityManager->persist($stagiaire);
            $entityManager->flush();

            return $this->redirectToRoute('app_stagiaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stagiaire/new.html.twig', [
            'stagiaire' => $stagiaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stagiaire_show', methods: ['GET'])]
    public function show(Stagiaire $stagiaire): Response
    {
        return $this->render('stagiaire/show.html.twig', [
            'stagiaire' => $stagiaire,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_stagiaire_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Stagiaire $stagiaire, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(StagiaireType::class, $stagiaire);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_stagiaire_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('stagiaire/edit.html.twig', [
            'stagiaire' => $stagiaire,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_stagiaire_delete', methods: ['POST'])]
    public function delete(Request $request, Stagiaire $stagiaire, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$stagiaire->getId(), $request->request->get('_token'))) {
            $entityManager->remove($stagiaire);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_stagiaire_index', [], Response::HTTP_SEE_OTHER);
    }
}


function getLocalisation($form): ?array {
    $localisation = $form->get("localisation")->getData();
    if (strlen($localisation['codesPostaux']) < 1) {
        unset($localisation['codesPostaux']);
    } else {
        $localisation['codesPostaux'] = array_map('trim', explode(",", $localisation['codesPostaux']));
    }
    if ($localisation['international']['ville'] == null && $localisation['international']['pays'] == null) {
        unset($localisation['international']);
    }
    sizeof($localisation) == 0 && $localisation = null;

    return $localisation;
}

function getSortedReseaux($form): ?array {
    $reseaux = $form->get("reseaux")->getData();
    $sortedReseaux= [];
    if ($reseaux != "" ) {
        $reseaux = array_map('trim', preg_split('/\R|\,/', $reseaux, -1, PREG_SPLIT_NO_EMPTY));
    } else {
        $reseaux = [];
        $sortedReseaux = null;
    }
    for ($i=0; $i < sizeof($reseaux) ; $i++) {
        if (str_contains($reseaux[$i], 'facebook')) $sortedReseaux['facebook'] = $reseaux[$i];
        else if (str_contains($reseaux[$i], 'twitter')) $sortedReseaux['twitter'] = $reseaux[$i];
        else if (str_contains($reseaux[$i], 'snapchat')) $sortedReseaux['snapchat'] = $reseaux[$i];
        else if (str_contains($reseaux[$i], 'linkedin')) $sortedReseaux['linkedin'] = $reseaux[$i];
        else $sortedReseaux['other'][] = $reseaux[$i];
    }

    return $sortedReseaux;
}