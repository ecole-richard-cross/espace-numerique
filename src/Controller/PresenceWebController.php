<?php

namespace App\Controller;

use App\Entity\PresenceWeb;
use App\Form\PresenceWebType;
use App\Repository\PresenceWebRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/presence/web')]
class PresenceWebController extends AbstractController
{
    #[Route('/', name: 'app_presence_web_index', methods: ['GET'])]
    public function index(PresenceWebRepository $presenceWebRepository): Response
    {
        return $this->render('presence_web/index.html.twig', [
            'presence_webs' => $presenceWebRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_presence_web_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $presenceWeb = new PresenceWeb();
        $form = $this->createForm(PresenceWebType::class, $presenceWeb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($presenceWeb);
            $entityManager->flush();

            return $this->redirectToRoute('app_presence_web_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('presence_web/new.html.twig', [
            'presence_web' => $presenceWeb,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_presence_web_show', methods: ['GET'])]
    public function show(PresenceWeb $presenceWeb): Response
    {
        return $this->render('presence_web/show.html.twig', [
            'presence_web' => $presenceWeb,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_presence_web_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, PresenceWeb $presenceWeb, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(PresenceWebType::class, $presenceWeb);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_presence_web_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('presence_web/edit.html.twig', [
            'presence_web' => $presenceWeb,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_presence_web_delete', methods: ['POST'])]
    public function delete(Request $request, PresenceWeb $presenceWeb, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$presenceWeb->getId(), $request->request->get('_token'))) {
            $entityManager->remove($presenceWeb);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_presence_web_index', [], Response::HTTP_SEE_OTHER);
    }
}
