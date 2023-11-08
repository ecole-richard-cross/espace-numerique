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
use ErrorException;
use Symfony\Component\Uid\Uuid;

class XMLExportController extends AbstractController
{
    private $doctrine;

    public function __construct(EntityManagerInterface $doctrine)
    {
        $this->doctrine = $doctrine;
    }

    #[Route('/xml_export', name: 'app_xml_export')]
    public function index(Request $request, PassageCertificationRepository $passageCertificationRepository): Response
    {
        $passagesCertification = $passageCertificationRepository->findAll();

        $errorCode = $request->get('error-code') ?? null;
        $error = $errorCode === "0" ? "Au moins un passage de certification doit être sélectionné." : null;

        return $this->render('xml_export/index.html.twig', [
            'passagesCertif' => $passagesCertification,
            'error' => $error
        ]);
    }


    #[Route('/to_xml', name: 'app_passage_certification_to_xml', methods: ['POST'])]
    public function toXml(Request $request): Response
    {
        $passages = $request->get('passages');
        if (!is_array($passages)) {
            return $this->redirectToRoute('app_xml_export', ['error-code' => "0"]);
        }

        $passageIds = array_map(function ($id) {
            return Uuid::fromString($id);
        }, $passages);

        $passagesToSer = $this->doctrine
            ->getRepository(PassageCertification::class)
            ->findFromIdList($passageIds);

        $converter = new XmlConverter();

        $xmlData = $converter->convertToXml(
            $passagesToSer,
            'cpf:flux',
            [
                '@xmlns:cpf' => 'urn:cdc:cpf:pc5:schema:1.0.0',
                '@xmlns:xsi' => "http://www.w3.org/2001/XMLSchema-instance",
            ]
        );
        $xsdSchema = 'validation-schema-2.0.0.xsd';
        $validation = $converter->validateXml($xmlData, $xsdSchema);
        if (!$validation) {
            $error = "Le fichier n'a pas pu être validé.";
            return $this->render('xml_export/to_xml_error.html.twig', [
                'error' => $error,
                'result' => $xmlData,
                'passages' => $passagesToSer
            ]);
        }

        return new Response($xmlData, 200, ["Content-Type" => "application/xml", "Content-Disposition" => "attachment; filename=declaration.xml"]);
    }
}
