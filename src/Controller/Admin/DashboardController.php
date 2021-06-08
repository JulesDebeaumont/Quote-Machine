<?php

namespace App\Controller\Admin;

use App\Entity\Category;
use App\Entity\Quote;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    /**
     * @Route("/admin", name="admin")
     */
    public function index(): Response
    {
        return $this->render('admin/dashboard.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Quote Machine');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::section('General');
        yield MenuItem::linkToCrud('Utilisateurs', 'fas fa-person', User::class);
        yield MenuItem::linkToCrud('Quotes', 'fas fa-person', Quote::class);
        yield MenuItem::linkToCrud('Catégories', 'fas fa-person', Category::class);
    }
}
