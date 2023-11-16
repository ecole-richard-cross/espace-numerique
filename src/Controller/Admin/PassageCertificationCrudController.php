<?php

namespace App\Controller\Admin;

use App\Entity\PassageCertification;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class PassageCertificationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PassageCertification::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('obtentionCertification')
                ->setChoices([
                    'PAR_SCORING' => 'PAR_SCORING',
                    'PAR_ADMISSION' => 'PAR_ADMISSION'
                ])
                ->setValue('PAR_SCORING')
                ->hideOnForm(),
            BooleanField::new('donneeCertifiee')
                ->setValue(true)
                ->hideOnForm(),
            BooleanField::new('presenceNiveauLangueEuro')
                ->setValue(false)
                ->hideOnForm(),
            BooleanField::new('presenceNiveauNumeriqueEuro')
                ->setValue(false)
                ->hideOnForm(),
            AssociationField::new('certification'),
            AssociationField::new('stagiaire'),
            TextField::new('scoring')
                ->setRequired(true),
            TextField::new('mentioValidee')
                ->hideOnForm(),
            DateField::new('dateDebutValidite')
                ->setRequired(true),
        ];
    }
}
