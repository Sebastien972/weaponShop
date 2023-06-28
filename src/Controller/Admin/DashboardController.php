<?php

namespace App\Controller\Admin;

use App\Entity\Armament;
use App\Entity\Caliber;
use App\Entity\Cart;
use App\Entity\Categorie;
use App\Entity\Order;
use App\Entity\TestCategorie;
use App\Entity\User;
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
        // return parent::index();

        // Option 1. You can make your dashboard redirect to some common page of your backend
        //
        $adminUrlGenerator = $this->container->get(AdminUrlGenerator::class);
        return $this->redirect($adminUrlGenerator->setController(ArmamentCrudController::class)->generateUrl());

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
            ->setTitle('Armeshot');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToDashboard('Dashboard', 'fa fa-home');
        yield MenuItem::linkToCrud('User', 'fas fa-list', User::class);
        yield MenuItem::linkToCrud('armament', 'fa-duotone fa-axe', Armament::class);
        yield MenuItem::linkToCrud('catégorie', 'fas fa-list', Categorie::class);
        yield MenuItem::linkToCrud('caliber', 'fas fa-list', Caliber::class);
        yield MenuItem::linkToCrud('order', 'fas fa-list', Order::class);
        yield MenuItem::linkToCrud('Cart', 'fas fa-list', Cart::class);
    }
}
