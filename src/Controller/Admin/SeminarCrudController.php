<?php

namespace App\Controller\Admin;

use App\Controller\Admin\Filter\ChoiceArrayFilter;
use App\Entity\Seminar;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Filter\BooleanFilter;

class SeminarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Seminar::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield FormField::addTab('Général');
        yield FormField::addColumn(6);
        yield FormField::addFieldset('');
        yield AssociationField::new('image', 'Illustration')
            ->onlyOnDetail()
            ->setTemplatePath('seminar/image_small.html.twig');

        ($_REQUEST['crudAction'] === Crud::PAGE_NEW ||
            $_REQUEST['crudAction'] === Crud::PAGE_EDIT) &&
            yield AssociationField::new('image', 'Illustration')
            ->addWebpackEncoreEntries('ea-force-media-type-value')
            ->renderAsEmbeddedForm(MediaImageCrudController::class)
            ->onlyOnForms();
        yield TextField::new('title', 'Titre')
            ->hideOnDetail();
        yield TextField::new('description');
        yield AssociationField::new('categories', 'Catégories')
            ->setTemplatePath('admin/collectionList.html.twig')
            ->setColumns(6);
        yield AssociationField::new('tags', 'Hashtags')
            ->setTemplatePath('admin/hashtagsList.html.twig')
            ->setColumns(6);
        yield FormField::addColumn(6);
        yield FormField::addFieldset('Paramètres')
            ->renderCollapsed();
        yield BooleanField::new('isPublished', 'Publié');
        yield ChoiceField::new('roles', 'Assigné à')
            ->setChoices(User::ROLES)
            ->allowMultipleChoices()
            ->renderExpanded()
            ->hideOnIndex();
        yield DateTimeField::new('createdAt', 'Créé le')
            ->hideOnForm();
        yield DateTimeField::new('updatedAt', 'Mis à jour le')
            ->hideOnForm();
        yield FormField::addColumn(12);
        yield FormField::addFieldset('Éditeur');
        yield CollectionField::new('chapters', 'Chapitres')
            ->hideOnIndex()
            ->addWebpackEncoreEntries('ea-block-form', 'ea-nested-text-editor-fix')
            ->useEntryCrudForm(ChapterCrudController::class);
        yield AssociationField::new('chapters', 'Chapitres')
            ->onlyOnIndex();
        yield CollectionField::new('chapters', "Aperçu")
            ->setTemplatePath('admin/seminarDisplay.html.twig')
            ->onlyOnDetail();
        yield FormField::addTab('Consulté par');
        yield FormField::addColumn(8);
        yield FormField::addFieldset('');
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
            ->setEntityLabelInSingular("Séminaire")
            ->setEntityLabelInPlural("Séminaires")
            ->setSearchFields(['title', 'description', "chapters.title", 'categories.name', 'tags.name']);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(BooleanFilter::new('isPublished'))
            ->add('categories')
            ->add('tags')
            ->add(ChoiceArrayFilter::new('roles')
                ->setChoices(['Admin' => 'ROLE_ADMIN', 'User' => 'ROLE_USER'])
                ->renderExpanded()
                ->canSelectMultiple());
    }
}
