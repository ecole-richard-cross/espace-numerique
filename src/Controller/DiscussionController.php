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
    #[Route('/nouvelle-discussion', name: 'app_discussion_new')]
    public function new(Request $req, EntityManagerInterface $em): Response
    {
        $discussion = new Discussion();
        $form = $this->createForm(DiscussionType::class, $discussion);

        $form->handleRequest($req);
        if ($form->isSubmitted()) {

            $content = preg_replace('/<\/?script.*>?/', '', $_POST['discussion']['content']);
            $tagsStr = $_POST['discussion']['tags']['tags'] ?? null;
            $tags = $tagsStr ? explode(',', $tagsStr) : [];

            if ($form->isValid() && strlen(strip_tags($content)) > 31) {

                foreach ($tags as $tag) {
                    $discussion
                        ->addTag($em->getRepository(Tag::class)->findOneBy(['id' => $tag]));
                }

                $comment = new Comment();
                $comment
                    ->setUser($this->getUser())
                    ->setContent($content)
                    ->setDiscussion($discussion);

                $discussion->setUser($this->getUser())
                    ->addComment($comment);

                $em->persist($discussion);
                $em->flush();

                return $this->redirectToRoute('app_discussion_read', ['id' => $discussion->getId()]);
            } else {
                if (empty($content)) {
                    $this->addFlash(
                        'warning',
                        'Votre commentaire ne peut pas être vide.'
                    );
                } elseif (strlen(strip_tags($content)) <= 31) {
                    $this->addFlash(
                        'warning',
                        'Votre commentaire est trop court, il doit être au minimum long d\'une vingtaine de caractères.'
                    );
                } else {
                    $this->addFlash(
                        'danger',
                        'Erreur inconnue, veuillez contacter le propriétaire du site.'
                    );
                }
            }
        }

        return $this->render('discussion/new.html.twig', ['form' => $form]);
    }

    #[Route('/lire-une-discussion/{id}', name: 'app_discussion_read')]
    public function readOne(Discussion $discussion, EntityManagerInterface $em, Request $request): Response
    {
        $comment = new Comment();
        $form = $this->createForm(CommentType::class, $comment);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $comment->setDiscussion($discussion);
            $comment->setUser($this->getUser());
            $em->persist($comment);
            $em->flush();
            return $this->redirectToRoute('app_discussion_read', ['id' => $discussion->getId()]);
        } else {
            $form->isSubmitted() && !$form->isValid() && $this->addFlash('danger', $form->getErrors());
        }

        return $this->render('discussion/viewOne.html.twig', [
            'question' => $discussion,
            'commentForm' => $form
        ]);
    }

    #[Route('/espace-discussion', name: 'app_discussion')]
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
