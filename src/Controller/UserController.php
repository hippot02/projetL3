<?php

namespace App\Controller;

use App\Form\EditMdpUserType;
use App\Form\EditProfilUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Security\Core\User\PasswordAuthenticatedUserInterface;
use Symfony\Component\Routing\Annotation\Route;
use Doctrine\Bundle\DoctrineBundle\Registry;
use Doctrine\Persistence\ManagerRegistry;


class UserController extends AbstractController
{
    #[Route('/user', name: 'app_user')]
    public function index(): Response
    {
        return $this->render('user/index.html.twig');
    }

    #[Route('/user/profil/modifier', name: 'app_user_profil_modif')]

    public function editProfil(Request $request, EntityManagerInterface $entityManager): Response

    {
        $user = $this->getUser();
        $form = $this->createForm(EditProfilUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($user);
            $entityManager->flush();
            $this->addFlash('message', 'Profil mis à jour !');
            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/editProfil.html.twig', ['form'
        => $form->createView()]);
    }

    #[Route('/user/Mot_de_passe/modifier', name: 'app_user_mdp_modif')]

    public function editMdp(Request $request, UserPasswordHasherInterface $passwordHasher, EntityManagerInterface $entityManager): Response

    {
        $user = $this->getUser();
        $form = $this->createForm(EditMdpUserType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setPassword(
                $passwordHasher->hashPassword(
                    $user,
                    $form->get('password')->getData()
                )
            );
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Profil mis à jour !');
            return $this->redirectToRoute('app_user');
        }

        return $this->render('user/editMdp.html.twig', ['form'
        => $form->createView()]);
    }
}
