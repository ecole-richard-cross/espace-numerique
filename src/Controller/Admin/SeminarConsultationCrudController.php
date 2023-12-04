<?php

namespace App\Controller\Admin;

use App\Entity\SeminarConsultation;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateTimeField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;

class SeminarConsultationCrudController extends AbstractCrudController
{
    public function __construct(private EntityManagerInterface $em)
    {
        
    }
    public static function getEntityFqcn(): string
    {
        return SeminarConsultation::class;
    }

    public function configureFields(string $pageName): iterable
    {
        if ($_REQUEST['crudControllerFqcn'] !== 'App\Controller\Admin\UserCrudController') {
            yield FormField::addColumn(4);
            yield AssociationField::new('user', false)
                ->renderAsNativeWidget();
        }
        if ($_REQUEST['crudControllerFqcn'] !== 'App\Controller\Admin\SeminarCrudController') {
            yield FormField::addColumn(4);
            yield AssociationField::new('seminar', false)
                ->renderAsNativeWidget();
        }
        yield FormField::addColumn(2);
        yield BooleanField::new('isToRead', 'Assigné');
        yield FormField::addColumn(2);
        yield BooleanField::new('isFinished', 'Terminé');
        yield FormField::addColumn(2)
            ->hideOnForm();
        yield DateTimeField::new('lastConsultedAt', 'Dernière Consultation le ')
            ->hideOnForm();
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined();
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->remove(Crud::PAGE_INDEX, Action::EDIT);
    }

    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add('user')
            ->add('seminar')
            ->add('isToRead')
            ->add('isFinished');
    }
}
