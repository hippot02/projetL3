<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserContactController extends AbstractController
{
    #[Route('/user/contact', name: 'app_user_contact')]
    public function index(): Response
    {
        if ($this->isGranted("ROLE_BLOCKED")) {
            return $this->redirectToRoute('app_home_page');
        }
        return $this->render('user_contact/index.html.twig', [
            'controller_name' => 'UserContactController',
        ]);
    }
}
