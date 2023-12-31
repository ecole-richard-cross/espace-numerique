<?php

namespace App\Controller\Admin;

use Exception;
use App\Entity\Media;
use Symfony\Bundle\SecurityBundle\Security;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Filters;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\NumberField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Filter\ChoiceFilter;
use EasyCorp\Bundle\EasyAdminBundle\Field\CollectionField;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

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

        $uploadNew = static function (UploadedFile $file, string $uploadDir, string $fileName) {
            if (
                !in_array(explode('/', $file->getMimeType())[0], ['image', 'audio', 'video']) &&
                !in_array($file->getMimeType(), [
                    // Text formats : txt, rtf, doc, docx
                    'text/plain',
                    'application/rtf',
                    'application/msword',
                    'application/vnd.openxmlformats-officedocument.wordprocessingml.document',

                    // Tab formats : csv, xls, xlsx
                    'text/csv',
                    'application/vnd.ms-excel',
                    'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',

                    // Data formats : XML, json
                    'application/xml',
                    'application/json',

                    // Compressed formats : zip, 7z and rar
                    'application/zip',
                    'application/x-7z-compressed',
                    'application/x-rar-compressed',

                    // Other : iCalendar, pdf, ppt and pptx
                    'text/calendar',
                    'application/pdf',
                    'application/vnd.ms-powerpoint',
                    'application/vnd.openxmlformats-officedocument.presentationml.presentation'
                ])
            )
                throw new Exception('Format de fichier refusé.');

            $file->move($uploadDir, $fileName);
        };

        yield ChoiceField::new('type')
            ->setChoices([
                'Image' => 'image',
                'Audio' => 'audio',
                'Vidéo' => 'video',
                'Fichier' => 'file'
            ])
            ->renderExpanded()
            ->onlyWhenCreating();
        yield TextField::new('name', 'Étiquette');
        ($pageName === Crud::PAGE_NEW) &&
            yield ImageField::new('url', 'Fichier')
            ->setFormTypeOptions([
                'upload_new' => $uploadNew
            ])
            ->onlyWhenCreating()
            ->setUploadDir('public/uploads')
            ->setBasePath('uploads/')
            ->setUploadedFileNamePattern('[contenthash].[extension]')
            ->setRequired($pageName === Crud::PAGE_NEW)
            ->addWebpackEncoreEntries('ea-media-form');

        yield TextField::new('url', 'Nom du fichier')
            ->hideOnForm();
        yield ImageField::new('url', 'Aperçu')
            ->onlyOnDetail()
            ->setTemplatePath('media/_show.html.twig');
        yield AssociationField::new('uploadedBy', 'Ajouté par')
            // ->hideOnForm()
            ->setValue($this->security->getUser() ?? null)
            ->setDisabled()
            ->onlyWhenCreating();

        yield NumberField::new('usesAmount', "Nombre d'utilisations")
            ->hideOnForm();
        yield CollectionField::new('uses', "Détail des utilisations")
            ->onlyOnDetail()
            ->setTemplatePath('admin/mediaUsesDetails.html.twig');
    }
    public function configureFilters(Filters $filters): Filters
    {
        return $filters
            ->add(ChoiceFilter::new('type')
                ->setChoices([
                    'Image' => 'image',
                    'Audio' => 'audio',
                    'Vidéo' => 'video',
                    'Fichier' => 'file'
                ]))
            ->add('name', 'Étiquette')
            ->add('uploadedBy', 'Ajouté par');
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->update(Crud::PAGE_INDEX, ACTION::DELETE, $this->allowDelete())
            ->update(Crud::PAGE_DETAIL, ACTION::DELETE, $this->allowDelete())
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud
            ->showEntityActionsInlined();
    }

    protected function allowDelete()
    {
        return function (Action $action) {
            return $action
                ->displayIf(static function (Media $entity) {
                    return (
                        $entity->getBlocks()->isEmpty() &&
                        $entity->getUsers()->isEmpty() &&
                        $entity->getSeminars()->isEmpty()
                    );
                });
        };
    }
}
