<?php

namespace App\Controller\Admin;

use App\Entity\Seminar;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
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
            yield IdField::new('id')
                ->hideOnForm();
            yield TextField::new('title');
            yield TextField::new('description');
            yield BooleanField::new('isPublished');
            $roles = ['ROLE_ADMIN', 'ROLE_USER'];
            yield ChoiceField::new('roles')
                ->setChoices(array_combine($roles, $roles))
                ->allowMultipleChoices()
                ->renderExpanded();
            yield DateTimeField::new('createdAt')
                ->hideOnForm();
            yield DateTimeField::new('updatedAt')
                ->hideOnForm();
            yield CollectionField::new('chapters')
                ->useEntryCrudForm(ChapterCrudController::class);
    }
    
}
