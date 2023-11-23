<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Filter\ChoiceArrayFilter;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\EmailField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TelephoneField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

class UserCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return User::class;
    }


    public function configureFields(string $pageName): iterable
    {
        $_REQUEST['crudAction'] !== 'detail' &&
            yield FormField::addTab('Général');
        yield FormField::addColumn(6);
        yield FormField::addFieldset('');
        yield TextField::new('prenom');
        yield TextField::new('nomNaissance');
        yield TextField::new('nomUsage')
            ->hideOnIndex();
        yield DateField::new('dateNaissance')
            ->hideOnIndex();
        yield TextField::new('nomStructure');
        yield TelephoneField::new('phoneNumber')
            ->hideOnIndex();
        yield FormField::addColumn(6);
        yield FormField::addFieldset('');
        yield EmailField::new('email');
        yield TextField::new('password'); // Remove before prod
        yield ChoiceField::new('roles')
            ->setChoices(['Admin' => 'ROLE_ADMIN', 'User' => 'ROLE_USER'])
            ->allowMultipleChoices()
            ->renderExpanded()
            ->hideOnIndex();
        yield FormField::addFieldset('');
        yield BooleanField::new('visio')
            ->hideOnIndex();
        yield ChoiceField::new('statut')
            ->setChoices(['Associé' => 'Associé', 'Indépendant' => 'Indépendant'])
            ->renderExpanded();
        yield FormField::addColumn(12);
        yield FormField::addFieldset('');
        yield CollectionField::new('presenceWebs')
            ->useEntryCrudForm()
            ->hideOnIndex();

        $_REQUEST['crudAction'] !== 'detail' &&
            yield FormField::addTab('Adresses');
        yield FormField::addColumn(12);
        yield FormField::addColumn(4);
        yield FormField::addFieldset('');
        yield AssociationField::new('adressePostale')
            ->renderAsEmbeddedForm()
            ->hideOnIndex();
        yield FormField::addColumn(8);
        yield FormField::addFieldset('');
        yield CollectionField::new('lieuxActivite')
            ->useEntryCrudForm()
            ->renderExpanded()
            ->hideOnIndex();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined()
            ->setSearchFields([
                'prenom', 'nomNaissance', 'nomUsage', "nomStructure", 'email', 'dateNaissance', 'presenceWebs.url',
                'adressePostale.adresse', 'adressePostale.codePostal', 'adressePostale.departement', 'adressePostale.region', 'adressePostale.ville', 'adressePostale.pays',
                'lieuxActivite.adresse', 'lieuxActivite.codePostal', 'lieuxActivite.departement', 'lieuxActivite.region', 'lieuxActivite.ville', 'lieuxActivite.pays'
            ]);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ChoiceArrayFilter::new('roles')
                ->setChoices(['Admin' => 'ROLE_ADMIN', 'User' => 'ROLE_USER'])
                ->renderExpanded()
                ->canSelectMultiple())
            ->add('visio');
    }
}
