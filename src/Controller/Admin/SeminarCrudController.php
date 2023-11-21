<?php

namespace App\Controller\Admin;

use App\Entity\Seminar;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\Field;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SeminarCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Seminar::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield FormField::addColumn(6);
        yield FormField::addFieldset('');
        yield TextField::new('title', 'Titre');
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
        $roles = ['ROLE_ADMIN', 'ROLE_USER'];
        yield ChoiceField::new('roles', 'Assigné à')
            ->setChoices(array_combine($roles, $roles))
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
            ->addCssFiles('styles\\ea-nested-forms.css')
            ->useEntryCrudForm(ChapterCrudController::class);
        yield CollectionField::new('chapters', "Aperçu")
            ->setTemplatePath('admin/seminarDisplay.html.twig')
            ->onlyOnDetail();
    }


    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined()
            ->setEntityLabelInSingular("Séminaire")
            ->setEntityLabelInPlural("Séminaires");
    }
}
