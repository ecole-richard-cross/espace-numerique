<?php

namespace App\Controller\Admin;

use App\Entity\Stagiaire;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;

class StagiaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Stagiaire::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            AssociationField::new('User', 'Utilisateur correspondant'),
            BooleanField::new('enFormation', 'En formation actuellement'),
            ChoiceField::new('sexe')
                ->setChoices(['M' => 'M', 'F' => 'F'])
                ->allowMultipleChoices(false),
            'codePostalNaissance',
            'idDossierCpf',
            TextareaField::new('identifiantsFinanceurs', 'Identifiants financeurs, 1 par ligne'),
            AssociationField::new('Promotion')
        ];
    }
}
