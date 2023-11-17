<?php

namespace App\Controller\Admin;

use App\Entity\Certification;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CertificationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Certification::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom'),
            ChoiceField::new('type')
                ->setChoices(['RNCP' => 'RNCP', 'RS' => 'RS'])
                ->renderExpanded()
                ->hideOnIndex(),
            TextField::new('code')->setMaxLength(9),
            DateField::new('startDate', 'Début de validité'),
            DateField::new('endDate', 'Fin de validité')
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined();
    }
}
