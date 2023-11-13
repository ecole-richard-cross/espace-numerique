# Cahier des charges | E-learning, Ecole Richard Cross

## Table des matières
* [Introduction](#introduction)
* [Objectifs](#objectifs)
* [Fonctionnalités](#détails-fonctionnels)
  + [Gestion des utilisateurs](#utilisateurs)
    - [Espace personnel](#espace-personnel)
    - [Fil de discussion](#forum-de-discussion)
    - [Data](#données)
  + [Gestion du contenu](#gestion-du-contenu)
    - [Médias](#médias-des-contenus)
    - [Organisation](#organisation-du-contenu)
    - [Formats](#formats)
    - [Affectation](#affectation-de-laccès-au-contenu)

## Introduction

L'objectif de ce projet est la réalisation d'une plateforme web pour l'Ecole Richard Cross.
Cette plateforme permettra à différents publics de consulter des contenus pédagogiques mis en place par l'équipe pédagogique de l'Ecole.

Une interface administrateur permettra à l'équipe pédagogique de gérer le contenu et l'accès des apprenants à celui-ci.

Un système de messagerie simple permettra une communication entre apprenants et formateurs.

## Objectifs

Pour le portail publique, il est nécessaire de recréer une charte graphique web plus professionnelle en respectant les couleurs clés de l'entreprise.
Cette charte graphique sera la base d'une refonte de tout l'écosystème web de l'entreprise (site ecole-richard-cross.fr, plateforme e-learning, et futurs projets).

Les outils développés et mis en place devront s'adapter sur tout support web, avoir des performances optimisées et respecter les normes d'accessibilité et de sécurité web.
Les interfaces réalisées (publiques, privées et administratives) devront être facile à prendre en main, avec des libellés clairs et sans ambiguïtés. 

## Détails fonctionnels

### Utilisateurs

Les utilisateurs seront répartis en 6 groupes :
- Le grand public : utilisateur externe à l'Ecole
- Les anciens stagiaires : utilisateur ayant effectué une formation au sein de l'Ecole
- Les stagiaires en formation : utilisateur étant actuellement en formation au sein de l'Ecole
- Les formateurs de l'Ecole
- Les formateurs externes à l'Ecole
- L'administration de l'Ecole, Richard (responsable pédagogique) et Colette (responsable administrative)

La plateforme doit pouvoir intégrer facilement de nouveaux groupes d'utilisateur en cas d'évolution du besoin.

#### Espace personnel

Chaque utilisateur enregistré disposera d'un suivi des articles qu'il a consulté ou non, et pourra les marquer comme Terminé, ou à consulter (liste de lecture).

#### Forum de discussion

Un système de fil de discussion publique permettra l'échange entre les stagiaires et l'équipe pédagogique.

Un système de partage de fichiers sera également disponible.

#### Données

Pour les utilisateurs enregistrés, la plateforme conservera les données nécessaires au fonctionnement de l'Ecole.

Le grand public pourra accéder à du contenu gratuit en échange des informations suivantes : 
- Prénom et nom et/ou nom de leur structure pédagogique
- Adresse électronique
- Code postal
- (département / région depuis code postal)

Ces données du grand public seront stockées dans la base de données de l'Ecole à des fins statistiques, et de prospection lors de l'ouverture des inscriptions pour les prochaines sessions de formation. Une inscription à la newsletter sera également possible mais facultative.

Aucun système de tracking d'utilisation ne sera mis en place.

Un système respectant le droit à l'accès et la suppression des données personnelles sera également mis en place. (email)

### Gestion du contenu

#### Médias des contenus

La plateforme doit permettre aux éditeurs de réaliser des articles pédagogiques contenant :
- du texte enrichi (gras, italique, liens, etc),
- des images,
- des lecteurs audios,
- des lecteurs vidéos,
- des pièces jointes diverses (pdf, doc, etc).

#### Organisation du contenu

Le contenu sera rangé selon deux facteurs :

1. Des catégories, correspondant aux thèmes des séminaires de l'Ecole *(respiration, rythme, vibration, etc),*
2. Des tags, ou mots-clés, plus spécifiques et servant à décrire au mieux le contenu en quelques mots ou expressions *(diaphragme, zone de passage, etc).*

Chaque article pourra être associé à une ou plusieurs catégories, un ou plusieurs mots-clés. Un page de tri permettra de voir les articles liés à une catégorie ou un mot-clé.

Une **fonction de recherche** permettra à l'utilisateur de trouver rapidement des articles selon le titre, les catégories ou les mots-clés.

#### Formats

Les articles auront des formats différents selon leur destination.

- Le grand public aura accès sous condition (cf [Données](#données)) à un format super-court, destiné à promouvoir le travail de l'Ecole et donner un aperçu de la formation.
- Les stagiaires de l'Ecole auront accès à des contenus spécialisés, notamment des mises en situation pour illustrer et développer les cours dispensés par l'Ecole.
- Les formateurs auront accès à des contenus réalisés spécifiquement pour eux par Richard


#### Affectation de l'accès au contenu

Chaque utilisateur aura un accès limité au contenu, selon plusieurs facteurs.

Les formateurs pourront organiser l'accès à du contenu aux stagiaires.

Le directeur pédagogique pourra organiser l'accès à du contenu aux formateurs et aux stagiaires.
