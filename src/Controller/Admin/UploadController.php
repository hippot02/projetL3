<?php

namespace App\Controller\Admin;

use App\Entity\Upload;
use EasyCorp\Bundle\EasyAdminBundle\Config\Dashboard;
use EasyCorp\Bundle\EasyAdminBundle\Config\MenuItem;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractDashboardController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;

class UploadController extends AbstractDashboardController
{
    #[Route('/upload', name: 'upload')]
    public function index(): Response
    {
        $securityContext = $this->container->get('security.authorization_checker');
        if (!($securityContext->isGranted('IS_AUTHENTICATED_REMEMBERED'))) {
            return $this->redirectToRoute('app_login');
        } else {
            $routeBuilder = $this->container->get(AdminUrlGenerator::class);
            return $this->redirect($routeBuilder->setController(UploadCrudController::class)->generateUrl());
        }
    }

    public function configureDashboard(): Dashboard
    {
        return Dashboard::new()
            ->setTitle('Upload Panel');
    }

    public function configureMenuItems(): iterable
    {
        yield MenuItem::linkToCrud('Upload', 'fas fa-file-upload', Upload::class);
        yield MenuItem::linkToRoute('Profile', 'fas fa-user', 'app_user');
    }


}