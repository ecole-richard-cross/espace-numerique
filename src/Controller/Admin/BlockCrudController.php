<?php

namespace App\Controller\Admin;

use App\Entity\Block;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\FormField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextEditorField;

class BlockCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Block::class;
    }


    public function configureFields(string $pageName): iterable
    {
        yield FormField::addColumn(12);
        $types = [
            "Texte" => 'text',
            "Image" => 'image',
            "Audio" => 'audio',
            "Video" => 'video',
            "Fichier" => 'file',
            "Question" => 'question',
            "Attention" => 'danger',
            "Information" => 'info',
            "Glossaire" => 'glossary'
        ];
        yield ChoiceField::new('type')
            ->setChoices($types);
        yield AssociationField::new('media');
        yield TextEditorField::new('content', 'Contenu');
        yield HiddenField::new('number');
        $_REQUEST['crudControllerFqcn'] == 'App\Controller\Admin\BlockCrudController' &&
            yield AssociationField::new('section');
    }


    function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
