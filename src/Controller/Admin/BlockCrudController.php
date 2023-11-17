<?php

namespace App\Controller\Admin;

use App\Entity\Block;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class BlockCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Block::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideOnForm();
        yield TextField::new('type');
        yield TextEditorField::new('content');
        yield IntegerField::new('number');
        $_REQUEST['crudControllerFqcn'] == 'App\Controller\Admin\BlockCrudController' &&
            yield AssociationField::new('section');
    }


    function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
