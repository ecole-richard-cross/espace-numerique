<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Discussion;
use App\Form\CommentType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscussionController extends AbstractController
{
    #[Route('/discussion/{id}', name: 'app_discussion_read')]
    public function readOne(int $id, EntityManagerInterface $em, Request $request): Response
    {
        $discussion = $em->getRepository(Discussion::class)->findOneBy(['id' => $id]);

        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setDiscussion($discussion);
            $comment->setUser($this->getUser());
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('app_discussion_read', ['id' => $id]);
        } else
            dump($form);

        return $this->render('discussion/viewOne.html.twig', [
            'question' => $discussion,
            'commentForm' => $form
        ]);
    }

    #[Route('/discussion', name: 'app_discussion')]
    public function index(EntityManagerInterface $em, Request $req): Response
    {
        $discussions = $em->getRepository(Discussion::class)->findAll();

        $myPage = $req->query->get('myPage') ?? 1;
        $myOffset = ($myPage - 1) * 5;
        $myLast5 = $em
            ->getRepository(Discussion::class)
            ->findBy(['user' => $this->getUser()], ['createdAt' => 'DESC'], 5, $myOffset);

        $page = $req->query->get('page') ?? 1;
        $offset = ($page - 1) * 5;
        $last5 = $em
            ->getRepository(Discussion::class)
            ->findBy([], ['createdAt' => 'DESC'], 5, $offset);

        return $this->render('discussion/index.html.twig', [
            'discussions' => $discussions,
            'myLast5' => $myLast5,
            'last5' => $last5,
            "page" => $page,
            "myPage" => $myPage
        ]);
    }
}
