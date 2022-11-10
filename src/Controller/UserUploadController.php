<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class UserUploadController extends AbstractController
{
    #[Route('/user/upload', name: 'app_user_upload')]
    public function index(): Response
    {
        if ($this->isGranted("ROLE_BLOCKED")) {
            return $this->redirectToRoute('app_home_page');
        }
        return $this->render('user_upload/index.html.twig', [
            'controller_name' => 'UserUploadController',
        ]);
    }
}
