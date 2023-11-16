<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class MediaCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Media::class;
    }

    public function configureFields(string $pageName): iterable
    {
            yield IdField::new('id')
                ->hideOnForm();
            yield TextField::new('type');
            yield TextField::new('url');
            yield TextField::new('name');
            yield DateTimeField::new('createdAt')
                ->hideOnForm();
            yield DateTimeField::new('updatedAt')
                ->hideOnForm();
            yield AssociationField::new('uploadedBy')
                ->hideOnForm();
    }
}
