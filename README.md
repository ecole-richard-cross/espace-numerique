# Outil de gestion de la base de données de l'Ecole Richard Cross (ERC)

Outil web destiné à numériser la gestion des stagiaires de l'ERC et leur formation.

## Features

- Système d'authentification (username/password)
- Gestion des stagiaires de l'Ecole
- Gestion des certifications proposées par l'Ecole
- Gestion des promotions annuelles de stagiaires
- Gestion des centres de formations de l'Ecole
- Gestion de passages de certification des stagiaires
- Export des passages de certification au format XML selon les spécifications de la Caisse des Dépôts

### Export des passages de certification au format XML

Omettre toute donnée facultative.

+ *1.1* : id unique du flux au format uuid
+ *1.2* : Horodatage à la création. Format à respecter, par exemple pour le 10 Juin 2020 à 17h21 : 2021-06-10T17:21:00+1:00
+ *2.1, 3.1, 3.2* : valeurs fixes d'identification, à stocker quelque part
+ *4.1* : type de certifications, uniquement RNCP ou RS
+ *4.2* : code de la certification
+ *5.1* : id unique du passage de certification, aucune contrainte de format
+ *5.4* : Système d'obtention "PAR_SCORING" (valeur à utiliser par défaut) ou "PAR_ADMISSION"
+ *5.5* : Caractère définitif de la certification. True par défaut.
+ *5.10* : Date de délivrance de la certification, format AAAA-MM-JJ
+ *5.12, 5.14* : Toujours false.
+ *5.15* : Score de l'examen (string, format libre).
+ *5.16* : Mention (toujours nil)
+ *7.1* : Toujours "FORMATION_INITIALE_HORS_APPRENTISSAGE"

Blocs 8 et 9, identification du certifié (état civil en bloc 8, par # de dossier CPF en bloc 9)

### Interface

L'interface doit être claire et facilement utilisable sans connaissance technique. 

## ETA

Le système doit être complété le plus tôt possible, en tenant compte des contraintes de sécurité, d'évolutivité et de maintenabilité du code.

## Changelog

8/11 : évolution du projet vers un système de gestion de base de données complète
6/11 : version initiale, convertisseur xml