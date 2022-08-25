<?php

namespace App\Controller\Admin;

use App\Entity\Booking;
use App\Entity\Message;
use App\Entity\Property;
use App\Entity\PropertyType;
use App\Entity\RatePlan;
use App\Entity\User;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class DashboardController extends AbstractDashboardController
{
    #[Route('/admin', name: 'admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig');
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Html');
    }

    public function configureMenuItems(): iterable
    {
        return [
            MenuItem::linkToDashboard('Dashboard', 'fa fa-home'),
            MenuItem::section('Menu'),
            MenuItem::linkToCrud('Bookings', '', Booking::class),
            MenuItem::linkToCrud('Properties', '', Property::class),
            MenuItem::linkToCrud('Rate Plans', '', RatePlan::class),
            MenuItem::linkToCrud('Property Types', '', PropertyType::class),
            MenuItem::linkToCrud('Messages', '', Message::class),
            MenuItem::linkToCrud('User', '', User::class),
        ];
    }
}
