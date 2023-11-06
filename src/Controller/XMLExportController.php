<?php

namespace App\Controller;

use App\Repository\PassageCertificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class XMLExportController extends AbstractController
{
    #[Route('/xml_export', name: 'app_xml_export')]
    public function index(PassageCertificationRepository $passageCertificationRepository): Response
    {
        $passagesCertification = $passageCertificationRepository->findAll();

        return $this->render('xml_export/index.html.twig', [
            'passagesCertif' => $passagesCertification
        ]);
    }
}
