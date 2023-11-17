<?php

namespace App\Controller\Admin;

use App\Entity\PresenceWeb;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Field\IdField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\UrlField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class PresenceWebCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PresenceWeb::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            ChoiceField::new('type')->setChoices([
                'Réseau social' => 'Réseau social',
                'Site web' => 'Site web',
            ])->allowMultipleChoices(false),
            UrlField::new('url'),
        ];
    }

    function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
