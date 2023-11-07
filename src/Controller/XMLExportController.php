<?php

namespace App\Controller;

use App\Entity\PassageCertification;
use App\Repository\PassageCertificationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Service\XmlConverter;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\Uid\Uuid;

class XMLExportController extends AbstractController
{
    private $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
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

        $passageIds = array_map(function ($id) {
            return Uuid::fromString($id);
        }, $request->get('passages'));

        $passagesToSer = $this->doctrine
            ->getRepository(PassageCertification::class)
            ->findFromIdList($passageIds);

        $converter = new XmlConverter();

        $xmlData = $converter->convertToXml($passagesToSer);

        return $this->render('xml_export/to_xml.html.twig', [
            'file' => $xmlFile,
            'result' => $xmlData,
            'passages' => $passagesToSer
        ]);
    }
}
