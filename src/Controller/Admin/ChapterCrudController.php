<?php

namespace App\Controller\Admin;

use App\Entity\Chapter;
use App\Controller\Admin\SectionCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class ChapterCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Chapter::class;
    }

    
    public function configureFields(string $pageName): iterable
    {
        yield IdField::new('id')
            ->hideOnForm();
        yield TextField::new('title');
        yield TextField::new('description');
        yield IntegerField::new('number');
        $_REQUEST['crudControllerFqcn'] == 'App\Controller\Admin\ChapterCrudController' && 
            yield AssociationField::new('seminar');
        yield CollectionField::new('sections')
            ->useEntryCrudForm(SectionCrudController::class);
    }

    function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
    
}
