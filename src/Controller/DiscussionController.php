<?php

namespace App\Controller;

use App\Entity\Comment;
use App\Entity\Discussion;
use App\Entity\Tag;
use App\Form\CommentType;
use App\Form\DiscussionType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DiscussionController extends AbstractController
{
    #[Route('/discussion/new', name: 'app_discussion_new')]
    public function new(Request $req, EntityManagerInterface $em): Response
    {
        $discussion = new Discussion();
        $form = $this->createForm(DiscussionType::class, $discussion);

        $form->handleRequest($req);
        if ($form->isSubmitted())
            if ($form->isValid()) {

                foreach ($_POST['discussion']['tags'] as $id => $tag) {
                    $discussion
                        ->addTag($em->getRepository(Tag::class)->findOneBy(['name' => $tag]));
                }

                $comment = new Comment();
                $comment
                    ->setUser($this->getUser())
                    ->setContent($_POST['discussion']['content'])
                    ->setDiscussion($discussion);

                $discussion->setUser($this->getUser())
                    ->addComment($comment);

                $em->persist($discussion);
                $em->flush();

                return $this->redirectToRoute('app_discussion_read', ['id' => $discussion->getId()]);
            } else {
                $this->addFlash(
                    'danger',
                    $form->getErrors()
                );
            }

        return $this->render('discussion/new.html.twig', ['form' => $form]);
    }

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
        } else {
            $form->isSubmitted() && !$form->isValid() && $this->addFlash('danger', $form->getErrors());
        }

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
