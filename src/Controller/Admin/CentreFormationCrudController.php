<?php

namespace App\Controller\Admin;

use App\Entity\CentreFormation;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class CentreFormationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return CentreFormation::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('name', 'Nom du centre'),
            AssociationField::new('localisation', 'Localisation')
                ->renderAsEmbeddedForm(LocalisationCrudController::class),
            DateField::new('debutActivite', "Début d'activité"),
            DateField::new('finActivite', "Fin d'activité")
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined()
            ->setEntityLabelInSingular('Centre de formation')
            ->setEntityLabelInPlural('Centres de formation');
    }
}
