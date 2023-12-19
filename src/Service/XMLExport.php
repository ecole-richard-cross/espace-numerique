<?php

namespace App\Service;

use App\Service\XmlConverter;
use Symfony\Component\Uid\Uuid;

class XMLExport
{
    static private function CpfFormat(array $data): array
    {
        date_default_timezone_set('Europe/Paris');
        $date = new \DateTimeImmutable();

        $certificationsList = [];
        $passageCertifications = [];

        foreach ($data as $passage) {
            $certification = $passage->getCertification();

            if (!in_array($certification, $certificationsList)) {
                $certificationsList[$certification->getId()] = $certification;
            }

            $stagiaire = $passage->getStagiaire();
            if ($stagiaire->getIdDossierCpf()) {
                $identificationTitulaire = [
                    "cpf:dossierFormation" => [
                        "cpf:idDossier" => $stagiaire->getIdDossierCpf(),
                        "cpf:nomTitulaire" => $stagiaire->getUser()->getNomNaissance(),
                        "cpf:prenom1Titulaire" => $stagiaire->getUser()->getPrenom()
                    ]
                ];
            } else {
                $identificationTitulaire = [
                    "cpf:titulaire" => [
                        "cpf:nomNaissance" => $stagiaire->getUser()->getNomNaissance(),
                        "cpf:nomUsage" => $stagiaire->getUser()->getNomUsage() ?? ["@xsi:nil" => "true", "#" => ""],
                        "cpf:prenom1" => $stagiaire->getUser()->getPrenom(),
                        "cpf:anneeNaissance" => $stagiaire->getUser()->getDateNaissance()->format('Y'),
                        "cpf:moisNaissance" => $stagiaire->getUser()->getDateNaissance()->format('m') ?? ["@xsi:nil" => "true", "#" => ""],
                        "cpf:jourNaissance" => $stagiaire->getUser()->getDateNaissance()->format('d') ?? ["@xsi:nil" => "true", "#" => ""],
                        "cpf:sexe" => $stagiaire->getSexe(),
                        "cpf:codeCommuneNaissance" => [
                            "cpf:codePostalNaissance" => [
                                "cpf:codePostal" => $stagiaire->getCodePostalNaissance() ?? ["@xsi:nil" => "true", "#" => ""],
                            ],
                        ]
                    ],
                ];
            }

            $passageCertification = [
                "cpf:idTechnique" => $passage->getId()->toRfc4122(),
                "cpf:obtentionCertification" => $passage->getObtentionCertification(),
                "cpf:donneeCertifiee" => $passage->__toStringIsDonneeCertifiee(),
                "cpf:dateDebutValidite" => $passage->getDateDebutValidite()->format('Y-m-d'),
                "cpf:dateFinValidite" => $passage->getDateFinValidite()?->format('Y-m-d') ?? ["@xsi:nil" => "true", "#" => ""],
                "cpf:presenceNiveauLangueEuro" => $passage->__toStringIsPresenceNiveauLangueEuro(),
                "cpf:presenceNiveauNumeriqueEuro" => $passage->__toStringIsPresenceNiveauNumeriqueEuro(),
                "cpf:scoring" => $passage->getScoring() ?? ["@xsi:nil" => "true", "#" => ""],
                "cpf:mentionValidee" => $passage->getMentionValidee() ?? ["@xsi:nil" => "true", "#" => ""],
                "cpf:modaliteInscription" => [
                    "cpf:modaliteAcces" => "FORMATION_INITIALE_HORS_APPRENTISSAGE",
                ],
                "cpf:identificationTitulaire" => $identificationTitulaire
            ];

            if (!array_key_exists($certification->getId(), $passageCertifications))
                $passageCertifications[$certification->getId()] = [$passageCertification];
            else
                array_push($passageCertifications[$certification->getId()], $passageCertification);
        }

        $cpfCertifications = array_map(function ($certification) use ($passageCertifications) {

            $passages = $passageCertifications[$certification->getId()];

            return
                [
                    "cpf:certification" => [
                        "cpf:type" => $certification->getType(),
                        "cpf:code" => $certification->getCode(),
                        "cpf:passageCertifications" => [
                            "cpf:passageCertification" => $passages
                        ],
                    ]
                ];
        }, $certificationsList);

        $formattedArray = [
            "cpf:idFlux" => ["#" => Uuid::v7()->toRfc4122()],
            "cpf:horodatage" => ["#" => $date->format('c')],
            "cpf:emetteur" => [
                "cpf:idClient" => getenv('CPF_ID_CLIENT'),
                "cpf:certificateur" => [
                    "cpf:idClient" => getenv('CPF_ID_CLIENT'),
                    "cpf:idContrat" => getenv('CPF_ID_CONTRAT'),
                    "cpf:certifications" => $cpfCertifications
                ],
            ]
        ];

        return $formattedArray;
    }

    static public function toXml(array $passages): array
    {

        $passagesToSer = self::CpfFormat($passages);
        $converter = new XmlConverter();

        $xmlData = $converter->convertToXml(
            $passagesToSer,
            'cpf:flux',
            [
                '@xmlns:cpf' => 'urn:cdc:cpf:pc5:schema:1.0.0',
                '@xmlns:xsi' => "http://www.w3.org/2001/XMLSchema-instance",
            ]
        );
        $xsdSchema = 'cpf-xml/validation-schema-2.0.0.xsd';
        $validation = $converter->validateXml($xmlData, $xsdSchema);
        if (!$validation['isValid']) {
            $error = "Le fichier n'a pas pu être validé.";
            return [
                'error' => $error,
                'errorMessage' => $validation['exception']->getMessage(),
                'data' => $xmlData,
                'passages' => $passages
            ];
        }

        return [
            'error' => false,
            'data' => $xmlData
        ];
    }
}
