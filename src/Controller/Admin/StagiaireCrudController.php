<?php

namespace App\Controller\Admin;

use App\Entity\Stagiaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;

class StagiaireCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Stagiaire::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('User', 'Utilisateur correspondant'),
            AssociationField::new('Promotion')->setTemplatePath('admin/collectionList.html.twig'),
            BooleanField::new('enFormation', 'En formation actuellement'),
            ChoiceField::new('sexe')
                ->setChoices(['M' => 'M', 'F' => 'F'])
                ->allowMultipleChoices(false)
                ->renderExpanded()
                ->hideOnIndex(),
            TextField::new('codePostalNaissance', 'Code postal de naissance')
                ->hideOnIndex(),
            TextField::new('idDossierCpf', 'Identifiant CPF'),
            TextareaField::new('identifiantsFinanceurs', 'Identifiants financeurs, 1 par ligne')->hideOnIndex()
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
