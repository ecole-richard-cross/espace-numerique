<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('prenom'),
            TextField::new('nomNaissance'),
            TextField::new('nomUsage')
                ->hideOnIndex(),
            TextField::new('nomStructure'),
            EmailField::new('email'),
            TextField::new('password'), // Remove before prod
            DateField::new('dateNaissance')
                ->hideOnIndex(),
            TelephoneField::new('phoneNumber')
                ->hideOnIndex(),
            BooleanField::new('visio')
                ->hideOnIndex(),
            ChoiceField::new('statut')
                ->setChoices([
                    'Associé' => 'Associé',
                    'Indépendant' => 'Indépendant',
                ])
                ->renderExpanded(),
            CollectionField::new('PresenceWebs')
                ->useEntryCrudForm()
                ->hideOnIndex(),
            AssociationField::new('adressePostale')
                ->renderAsEmbeddedForm()
                ->hideOnIndex(),
            CollectionField::new('lieuxActivite')
                ->useEntryCrudForm()
                ->hideOnIndex()
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined();
    }
}
