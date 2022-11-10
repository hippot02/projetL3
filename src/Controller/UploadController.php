<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\BrowserKit\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\String\Slugger\SluggerInterface;


class UploadController extends AbstractController
{



    #[Route('/upload', name: 'app_upload')]
    public function index(): Response
    {
        if ($this->isGranted("ROLE_BLOCKED")) {
            return $this->redirectToRoute('app_home_page');
        }
        return $this->render('upload/index.html.twig', [
            'controller_name' => 'UploadController',
        ]);
    }
}
