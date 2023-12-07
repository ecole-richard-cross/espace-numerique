<?php

namespace App\Controller\Admin;

use App\Entity\Discussion;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Asset;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class DiscussionCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Discussion::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('title', 'Titre'),
            AssociationField::new('user', 'Auteur')->setRequired(true),
            AssociationField::new('categories', 'Catégorie')
                ->setTemplatePath('admin/hashtagsList.html.twig'),
            AssociationField::new('tags', 'Hashtags')
                ->setTemplatePath('admin/hashtagsList.html.twig'),
            AssociationField::new('comments')
                ->onlyOnIndex(),
            CollectionField::new('comments', 'Commentaires')
                ->hideOnIndex()
                ->useEntryCrudForm(CommentCrudController::class)
                ->setTemplatePath('admin/collectionList.html.twig')
                ->addWebpackEncoreEntries('ea-nested-text-editor-fix'),
            DateTimeField::new('updatedAt')
                ->hideOnForm(),
            DateTimeField::new('createdAt')
                ->hideOnForm(),
        ];
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
