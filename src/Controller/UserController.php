<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;

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
}
