<?php

namespace App\Controller;

use App\Entity\Tag;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class TagController extends AbstractController
{
    #[Route('/theme/{tag}', name: 'app_tag_show')]
    public function index(Tag $tag): Response
    {
        $seminars = $tag->getSeminars()->toArray();
        $filteredSeminars = array_filter($seminars, function ($s) {
            return $s->isIsPublished() && !empty(array_intersect($s->getRoles(), $this->getUser()->getRoles()));
        });
        return $this->render('tag/index.html.twig', [
            'tag' => $tag,
            'filteredSeminars' => $filteredSeminars
        ]);
    }
}
