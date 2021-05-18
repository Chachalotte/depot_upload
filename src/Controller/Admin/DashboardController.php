<?php

namespace App\Controller\Admin;

use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Router\CrudUrlGenerator;
use App\Controller\Admin\CategoryCrudController;
use App\Entity\User;
use App\Entity\Travaux;
use App\Entity\Category;

use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     *
     * @return Response 
     */
    public function index(): Response
    {
        $routeBuilder = $this->get(AdminUrlGenerator::class);

        return $this->redirect($routeBuilder->setController(CategoryCrudController::class)->generateUrl());    
    
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Lp Dev');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('Important');
        yield MenuItem::linkToCrud('Utilisateurs', 'fa fa-file-pdf', User::class);
        yield MenuItem::linkToCrud('Catégories', 'fa fa-file-pdf', Category::class);
        yield MenuItem::linkToCrud('Travaux', 'fa fa-file-pdf', Travaux::class);

    }
}
