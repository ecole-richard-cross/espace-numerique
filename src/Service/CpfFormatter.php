<?php

use Symfony\Component\Uid\Uuid;

function CpfFormat(array $data): array
{
    date_default_timezone_set('Europe/Paris');
    $date = new DateTimeImmutable();

    $passageCertifications = [];
    foreach ($data as $passage) {

        $stagiaire = $passage->getStagiaire();
        if ($stagiaire->getIdDossierCpf()) {
            $identificationTitulaire = [
                "cpf:dossierFormation" => [
                    "cpf:idDossier" => $stagiaire->getIdDossierCpf(),
                    "cpf:nomTitulaire" => $stagiaire->getNomNaissance(),
                    "cpf:prenom1Titulaire" => $stagiaire->getPrenom()
                ]
            ];
        } else {
            $identificationTitulaire = [
                "cpf:titulaire" => [
                    "cpf:nomNaissance" => $stagiaire->getNomNaissance(),
                    "cpf:nomUsage" => $stagiaire->getNomUsage(),
                    "cpf:prenom1" => $stagiaire->getPrenom(),
                    "cpf:anneeNaissance" => $stagiaire->getDateNaissance()->format('Y'),
                    "cpf:moisNaissance" => $stagiaire->getDateNaissance()->format('m'),
                    "cpf:jourNaissance" => $stagiaire->getDateNaissance()->format('d'),
                    "cpf:sexe" => $stagiaire->getSexe(),
                    "cpf:codeCommuneNaissance" => [
                        "cpf:codePostalNaissance" => [
                            "cpf:codePostal" => $stagiaire->getCodePostalNaissance(),
                        ],
                    ]
                ],
            ];
        }

        $passageCertification = [
            "cpf:passageCertification" => [
                "cpf:idTechnique" => $passage->getId()->toRfc4122(),
                "cpf:obtentionCertification" => $passage->getObtentionCertification(),
                "cpf:donneeCertifiee" => $passage->__toStringIsDonneeCertifiee(),
                "cpf:dateDebutValidite" => $passage->getDateDebutValidite()->format('Y-m-d'),
                "cpf:dateFinValidite" => ["@xsi:nil" => "true", "#" => ""],
                "cpf:presenceNiveauLangueEuro" => $passage->__toStringIsPresenceNiveauLangueEuro(),
                "cpf:presenceNiveauNumeriqueEuro" => $passage->__toStringIsPresenceNiveauNumeriqueEuro(),
                "cpf:scoring" => $passage->getScoring(),
                "cpf:mentionValidee" => $passage->getMentionValidee() ?? ["@xsi:nil" => "true", "#" => ""],
                "cpf:modaliteInscription" => [
                    "cpf:modaliteAcces" => "FORMATION_INITIALE_HORS_APPRENTISSAGE",
                ],
                "cpf:identificationTitulaire" => $identificationTitulaire
            ],
        ];

        array_push($passageCertifications, $passageCertification);
    }
    $formattedArray = [
        "cpf:idFlux" => ["#" => Uuid::v7()->toRfc4122()],
        "cpf:horodatage" => ["#" => $date->format('c')],
        "cpf:emetteur" => [
            "cpf:idClient" => [],
            "cpf:certificateur" => [
                "cpf:idClient" => [],
                "cpf:idContrat" => [],
                "cpf:certifications" => [
                    "cpf:certification" => [
                        "cpf:type" => [],
                        "cpf:code" => [],
                        "cpf:passageCertifications" => $passageCertifications
                    ],
                ],
            ],
        ]
    ];

    return $formattedArray;
}
