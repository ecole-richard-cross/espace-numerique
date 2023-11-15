<?php

namespace App\Controller\Admin;

use App\Entity\CentreFormation;
use App\Entity\Certification;
use App\Entity\PassageCertification;
use App\Entity\Promotion;
use App\Entity\Stagiaire;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Option 1. You can make your dashboard redirect to some common page of your backend

        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect(
            $adminUrlGenerator
                ->setController(StagiaireCrudController::class)
                ->generateUrl()
        );

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        // return $this->render('some/path/my-dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Espace Numerique')
            ->setLocales(['fr']);
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Accueil', 'fa fa-home'),
            Menuitem::subMenu('Gestion', 'fa fa-list')->setSubItems([
                MenuItem::linkToCrud('Stagiaires', 'fas fa-list', Stagiaire::class),
                MenuItem::linkToCrud('Certifications', 'fas fa-list', Certification::class),
                MenuItem::linkToCrud('Passages d\'une certification', 'fas fa-list', PassageCertification::class),
                MenuItem::linkToCrud('Promotions', 'fas fa-list', Promotion::class),
                MenuItem::linkToCrud('Centres de formation', 'fas fa-list', CentreFormation::class),
            ])
        ];
    }
}
