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
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
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
                ->setTemplatePath('admin/collectionList.html.twig'),
            AssociationField::new('tags', 'Hashtags')
                ->setTemplatePath('admin/hashtagsList.html.twig'),
            CollectionField::new('comments', 'Commentaires')
                ->useEntryCrudForm(CommentCrudController::class)
                ->setTemplatePath('admin/collectionList.html.twig')
                ->addJsFiles(
                    Asset::new('scripts/ea-nested-text-editor-fix.js')
                        ->defer()
                ),
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
