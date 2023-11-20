<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use Symfony\Bundle\SecurityBundle\Security;

class MediaCrudController extends AbstractCrudController
{
    private $security;
    public function __construct(Security $security)
    {
        $this->security = $security;
    }
    public static function getEntityFqcn(): string
    {
        return Media::class;
    }

    public function configureFields(string $pageName): iterable
    {
        yield ChoiceField::new('type')
            ->setChoices([
                'Image' => 'image',
                'Audio' => 'audio',
                'Vidéo' => 'video',
                'Fichier' => 'file'
            ])
            ->renderExpanded();
        yield TextField::new('name');
        yield ImageField::new('url')
            ->setUploadDir('public/uploads')
            ->setBasePath('uploads/')
            ->setUploadedFileNamePattern('[contenthash].[extension]')
            ->hideOnIndex()
            ->hideOnDetail();
        yield TextField::new('url')
            ->hideOnForm();
        yield AssociationField::new('uploadedBy')
            // ->hideOnForm()
            ->setValue($this->security->getUser());
    }

    function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
