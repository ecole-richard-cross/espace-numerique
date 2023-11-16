<?php

namespace App\Controller\Admin;

use App\Controller\IndexController;
use App\Entity\CentreFormation;
use App\Entity\Certification;
use App\Entity\PassageCertification;
use App\Entity\PresenceWeb;
use App\Entity\Promotion;
use App\Entity\Stagiaire;
use App\Entity\User;
use Doctrine\ORM\EntityManagerInterface;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    private $entityManager;
    public function __construct(EntityManagerInterface $entityManager)
    {
        $this->entityManager = $entityManager;
    }

    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        // Option 1. You can make your dashboard redirect to some common page of your backend

        // $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        // return $this->redirect(
        //     $adminUrlGenerator
        //         ->setController(IndexController::class)
        //         ->generateUrl()
        // );

        // Option 2. You can make your dashboard redirect to different pages depending on the user
        //
        // if ('jane' === $this->getUser()->getUsername()) {
        //     return $this->redirect('...');
        // }

        // Option 3. You can render some custom template to display a proper dashboard with widgets, etc.
        // (tip: it's easier if your template extends from @EasyAdmin/page/content.html.twig)
        //
        $stagiaires = $this->entityManager->getRepository(Stagiaire::class)->findAll();
        $certifs = $this->entityManager->getRepository(Certification::class)->findAll();
        return $this->render('admin/index.html.twig', [
            "stagiaires" => $stagiaires,
            "certifications" => $certifs
        ]);
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('<h1 style="color: var(--purple-600); font-size: 1.33rem;">Administration Espace Numérique Ecole Richard Cross</h1>')
            ->setLocales(['fr']);
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Accueil', 'fa fa-home'),
            Menuitem::subMenu('Gestion', 'fa fa-list')
                ->setSubItems([
                    MenuItem::section("Certification"),
                    MenuItem::linkToCrud('Certifications', 'fas fa-scroll', Certification::class),
                    MenuItem::linkToCrud('Stagiaires', 'fas fa-user', Stagiaire::class),
                    MenuItem::linkToCrud("Passage d'une certification", 'fas fa-user-graduate', PassageCertification::class),
                    MenuItem::section("Ecole"),
                    MenuItem::linkToCrud('Centres de formation', 'fas fa-school', CentreFormation::class),
                    MenuItem::linkToCrud('Promotions', 'fa fa-people-group', Promotion::class),
                    MenuItem::section("Web"),
                    MenuItem::linkToCrud('Utilisateurs', 'fa-regular fa-user', User::class),
                ])
        ];
    }
}
