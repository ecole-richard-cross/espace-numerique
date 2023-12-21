<?php

namespace App\Controller\Admin;

use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use App\Controller\Admin\Filter\ChoiceArrayFilter;
use App\Entity\Media;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
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

    public function createEntity(string $entityFqcn): User
    {
        $user = parent::createEntity($entityFqcn);
        $user
            ->setAvatar(new Media())
            ->getAvatar()
            ->setCreatedAt(new \DateTimeImmutable())
            ->setUploadedBy($this->getUser())
            ->setType('image')
            ->setName('avatar-' . $this->getUser());
        return $user;
    }

    public function configureFields(string $pageName): iterable
    {
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

        yield FormField::addFieldset('');
        yield CollectionField::new('presenceWebs')
            ->useEntryCrudForm()
            ->hideOnIndex();

        yield FormField::addColumn(6);
        yield AssociationField::new('avatar')
            ->onlyOnDetail()
            ->setTemplatePath('admin/avatar_small.html.twig');
        yield AssociationField::new('avatar')
            ->onlyOnIndex()
            ->setTemplatePath('admin/avatar_tiny.html.twig');

        yield AssociationField::new('avatar')
            ->addWebpackEncoreEntries('ea-force-media-type-value')
            ->renderAsEmbeddedForm(MediaImageCrudController::class)
            ->setRequired(false)
            ->onlyOnForms();

        yield FormField::addFieldset('');
        yield EmailField::new('email');
        yield TextField::new('password'); // Remove before prod
        yield BooleanField::new('isVerified', 'Compte vérifié')
            ->hideOnIndex();
        yield ChoiceField::new('roles')
            ->setChoices(User::ROLES)
            ->allowMultipleChoices()
            ->renderExpanded()
            ->hideOnIndex();
        yield FormField::addFieldset('');
        yield BooleanField::new('visio')
            ->hideOnIndex();
        yield ChoiceField::new('statut')
            ->setChoices(['Associé' => 'Associé', 'Indépendant' => 'Indépendant'])
            ->renderExpanded();

        $_REQUEST['crudAction'] !== 'detail' &&
            yield FormField::addTab('Adresses');
        yield FormField::addColumn(12);
        yield FormField::addColumn(4);
        yield FormField::addFieldset('Adresse Postale');
        yield AssociationField::new('adressePostale', false)
            ->renderAsEmbeddedForm()
            ->onlyOnForms();
        yield TextField::new('adressePostale', false)
            ->onlyOnDetail();
        yield FormField::addColumn(8);
        yield FormField::addFieldset('Lieux d\'activité');
        yield CollectionField::new('lieuxActivite', false)
            ->useEntryCrudForm()
            ->renderExpanded()
            ->hideOnIndex();

        yield FormField::addTab('Articles Consultés');
        yield FormField::addColumn(6);
        yield FormField::addFieldset('Articles');
        yield CollectionField::new('seminarConsultations', false)
            ->addWebpackEncoreEntries('ea-consultation-no-duplicates')
            ->setTemplatePath('admin/consultationDisplay.html.twig')
            ->useEntryCrudForm()
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
