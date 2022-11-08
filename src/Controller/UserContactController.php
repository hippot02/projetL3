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
        return $this->render('user_contact/index.html.twig', [
            'controller_name' => 'UserContactController',
        ]);
    }
}
