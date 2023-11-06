<?php

namespace App\Controller;

use App\Entity\PassageCertification;
use App\Repository\PassageCertificationRepository;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class XMLExportController extends AbstractController
{
    private $doctrine;

    public function __construct(ManagerRegistry $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/xml_export', name: 'app_xml_export')]
    public function index(PassageCertificationRepository $passageCertificationRepository): Response
    {
        $passagesCertification = $passageCertificationRepository->findAll();

        return $this->render('xml_export/index.html.twig', [
            'passagesCertif' => $passagesCertification
        ]);
    }


    #[Route('/to_xml', name: 'app_passage_certification_to_xml', methods: ['POST'])]
    public function toXml(Request $request): Response
    {
        $xmlFile = null;

        $passageIds = $request->get('passages');

        $passagesToParse = $this->doctrine
            ->getRepository(PassageCertification::class)
            ->findBy(['id' => $passageIds]);

        return $this->render('xml_export/to_xml.html.twig', [
            'file'=>$xmlFile,
            'result'=>$passageIds
        ]);
    }
}
