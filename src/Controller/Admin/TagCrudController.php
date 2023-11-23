<?php

namespace App\Controller\Admin;

use App\Entity\Tag;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;

class TagCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Tag::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield TextField::new('name');
        $_REQUEST['crudControllerFqcn'] == 'App\Controller\Admin\TagCrudController' &&
            yield AssociationField::new('seminars')
            ->setTemplatePath('admin/collectionList.html.twig')
            ->setFormTypeOptionIfNotSet('by_reference', false);
        $_REQUEST['crudControllerFqcn'] == 'App\Controller\Admin\TagCrudController' &&
            yield AssociationField::new('discussions')
            ->setTemplatePath('admin/collectionList.html.twig')
            ->setFormTypeOptionIfNotSet('by_reference', false);
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
            ->setEntityLabelInSingular("Hashtag")
            ->setEntityLabelInPlural("Hashtags");
    }
}
