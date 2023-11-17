<?php

namespace App\Controller\Admin;

use App\Entity\SeminarConsultation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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


    function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
