<?php

namespace App\Controller\Admin;

use App\Entity\Media;
use Symfony\Bundle\SecurityBundle\Security;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Symfony\Component\Validator\Constraints\File;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use Exception;

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
            dump($file->getMimeType());
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
            ->renderExpanded();
        yield TextField::new('name', 'Étiquette');
        yield ImageField::new('url', 'Fichier')
            ->setFormTypeOptions([
                'upload_new' => $uploadNew
            ])
            ->setUploadDir('public/uploads')
            ->setBasePath('uploads/')
            ->setUploadedFileNamePattern('[contenthash].[extension]')
            ->onlyOnForms()
            ->setRequired($pageName === Crud::PAGE_NEW)
            ->addJsFiles('scripts/ea-media-form.js');
        yield TextField::new('url', 'Nom du fichier')
            ->hideOnForm();
        yield AssociationField::new('uploadedBy', 'Ajouté par')
            // ->hideOnForm()
            ->setValue($this->security->getUser() ?? null);
    }

    function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL);
    }
}
