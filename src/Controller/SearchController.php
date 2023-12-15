<?php

namespace App\Controller;

use App\Service\SearchDatabase;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class SearchController extends AbstractController
{
    #[Route('/rechercher', name: 'app_search')]
    public function index(Request $req, EntityManagerInterface $em): Response
    {
        $q = $req->query->get('q');

        if (strlen($q) < 3) {
            $this->addFlash(
                'warning',
                'Le champ de recherche nécessite au moins 3 caractères pour fonctionner.'
            );
            $route = $req->headers->get('referer');
            return $this->redirect($route);
        }

        $results = SearchDatabase::find($q, $em);

        return $this->render('search/results.html.twig', [
            'results' => $results,
            'q' => $q
        ]);
    }
}
