<?php

namespace App\Controller\Admin;

use App\Entity\SeminarConsultation;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class SeminarConsultationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return SeminarConsultation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        
            yield IdField::new('id')
                ->hideOnForm();
            yield BooleanField::new('isToRead');
            yield BooleanField::new('isFinished');
            yield DateTimeField::new('lastConsultedAt');
            yield AssociationField::new('user');
            yield AssociationField::new('seminar');
    }
    
}
