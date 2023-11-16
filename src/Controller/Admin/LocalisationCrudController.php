<?php

namespace App\Controller\Admin;

use App\Entity\Localisation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class LocalisationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Localisation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('adresse', 'Numéro et libellé de voie'),
            'codePostal',
            'ville',
            'pays'
        ];
    }
}
