<?php

namespace App\Service;

use App\Entity\Block;
use App\Entity\Comment;
use App\Entity\Discussion;
use App\Entity\Seminar;
use App\Entity\Tag;
use Doctrine\ORM\EntityManagerInterface;

class SearchDatabase
{
    static function find(string $query, EntityManagerInterface $em): array
    {
        $discussions = $em->getRepository(Discussion::class)->searchFor($query);
        $seminars = $em->getRepository(Seminar::class)->searchFor($query);

        $comments = $em->getRepository(Comment::class)->searchFor($query);
        foreach ($comments as $comment) {
            $discussions[] = $comment->getDiscussion();
        }

        $tags = $em->getRepository(Tag::class)->searchFor($query);
        foreach ($tags as $tag) {
            $discussions = array_merge($discussions, $tag->getDiscussions()->toArray());
            $seminars = array_merge($seminars, $tag->getSeminars()->toArray());
        }

        $blocks = $em->getRepository(Block::class)->searchFor($query);
        foreach ($blocks as $block) {
            $seminars[] = $block->getSection()->getChapter()->getSeminar();
        }

        return [
            'discussions' => array_unique($discussions),
            'seminars' => array_unique($seminars)
        ];
    }
}
