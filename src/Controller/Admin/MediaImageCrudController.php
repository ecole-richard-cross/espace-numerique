<?php

namespace App\Controller\Admin;

use Exception;
use App\Entity\Media;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\HiddenField;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;

class MediaImageCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Media::class;
    }

    public function configureFields(string $pageName): iterable
    {
        $uploadNew = static function (UploadedFile $file, string $uploadDir, string $fileName) {
            if (explode('/', $file->getMimeType())[0] !== 'image')
                throw new Exception('Format de fichier refusé.');
            $file->move($uploadDir, $fileName);
        };
        yield HiddenField::new('type');
        yield HiddenField::new('name');
        yield ImageField::new('url', 'Fichier')
            ->setFormTypeOptions([
                'upload_new' => $uploadNew
            ])
            ->setUploadDir('public/uploads')
            ->setBasePath('uploads/')
            ->setUploadedFileNamePattern('[contenthash].[extension]')
            ->onlyOnForms();
    }
}
