<?php

namespace App\Controller\Admin;

use App\Entity\PassageCertification;
use App\Service\XMLExport;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Assets;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\BatchActionDto;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ChoiceField;
use EasyCorp\Bundle\EasyAdminBundle\Field\DateField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Symfony\Component\HttpFoundation\Response;

class PassageCertificationCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return PassageCertification::class;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            AssociationField::new('stagiaire'),
            AssociationField::new('certification'),
            TextField::new('scoring'),
            DateField::new('dateDebutValidite', 'Remise de la certification')
                ->setRequired(true),
            TextField::new('mentionValidee', 'Mention')
                ->hideOnForm()
                ->hideOnIndex()
                ->hideOnDetail(),
            ChoiceField::new('obtentionCertification')
                ->setChoices([
                    'PAR_SCORING' => 'PAR_SCORING',
                    'PAR_ADMISSION' => 'PAR_ADMISSION'
                ])
                ->hideOnForm()
                ->hideOnIndex()
                ->hideOnDetail(),
            BooleanField::new('donneeCertifiee')
                ->hideOnForm()
                ->hideOnIndex()
                ->hideOnDetail(),
            BooleanField::new('presenceNiveauLangueEuro')
                ->hideOnForm()
                ->hideOnIndex()
                ->hideOnDetail(),
            BooleanField::new('presenceNiveauNumeriqueEuro')
                ->hideOnForm()
                ->hideOnIndex()
                ->hideOnDetail(),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        return $actions
            ->add(Crud::PAGE_INDEX, Action::DETAIL)
            ->addBatchAction(Action::new('exportXml', 'Exporter le XML')
                ->linkToCrudAction('exportXml')
                ->addCssClass('btn btn-primary')
                ->setIcon('fa fa-file-code'));
    }

    public function configureCrud(Crud $crud): Crud
    {
        return $crud->showEntityActionsInlined()
            ->setEntityLabelInSingular('Passage de certification')
            ->setEntityLabelInPlural('Passages de certification');
    }

    public function configureAssets(Assets $assets): Assets
    {
        return $assets
            ->addWebpackEncoreEntry('remove-xml-batch-popup');
    }

    public function exportXml(BatchActionDto $batchActionDto): Response
    {
        $fqcn = $batchActionDto->getEntityFqcn();
        $entityManager = $this->container->get('doctrine')->getManagerForClass($fqcn);

        $passages = array_map(function ($id) use ($entityManager, $fqcn) {
            return $entityManager->find($fqcn, $id);
        }, $batchActionDto->getEntityIds());
        $result = XMLExport::toXml($passages);
        if ($result['error']) {
            return $this->render('xml_export/error.html.twig', $result);
            dd($result);
        }

        $xml = new Response($result['data'], 200, ["Content-Type" => "application/xml", "Content-Disposition" => "attachment; filename=declaration.xml"]);
        return $xml;
    }
}
