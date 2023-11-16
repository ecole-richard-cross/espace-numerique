<?php

namespace App\Controller\Admin;

use App\Entity\CentreFormation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CentreFormationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CentreFormation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom du centre'),
            DateField::new('debutActivite', "Début d'activité"),
            DateField::new('finActivite', "Fin d'activité"),
            AssociationField::new('localisation', 'Localisation')
                ->renderAsEmbeddedForm(LocalisationCrudController::class)
        ];
    }
}
