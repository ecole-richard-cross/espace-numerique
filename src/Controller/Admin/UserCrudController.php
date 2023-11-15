<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            IdField::new('id')->hideOnForm(),
            EmailField::new('email'),
            TextField::new('nomNaissance'),
            TextField::new('nomUsage'),
            TextField::new('prenom'),
            TextField::new('nomStructure'),
            DateField::new('dateNaissance'),
            TelephoneField::new('phoneNumber'),
            BooleanField::new('visio'),
            ChoiceField::new('statut')->setChoices([
                'Associé' => 'Associé',
                'Indépendant' => 'Indépendant',
            ]),
            CollectionField::new('PresenceWebs')
                ->useEntryCrudForm(),
            AssociationField::new('adressePostale')
                ->renderAsEmbeddedForm(),
            CollectionField::new('lieuxActivite')
                ->useEntryCrudForm()

        ];
    }
}
