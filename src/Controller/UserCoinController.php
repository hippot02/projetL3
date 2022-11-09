<?php

namespace App\Controller;

use App\Form\EditCoinAdminType;
use App\Form\EditMdpUserType;
use App\Form\EditProfilUserType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\PasswordHasher\Hasher\UserPasswordHasherInterface;
use Symfony\Component\Routing\Annotation\Route;

class UserCoinController extends AbstractController
{
    #[Route('/user/coin', name: 'app_user_coin')]
    public function index(): Response
    {
        return $this->render('user_coin/index.html.twig', [
            'controller_name' => 'UserCoinController',
        ]);
    }
    #[Route('/user/coin/modifier', name: 'app_user_coin_modif')]
    public function addCoin(Request $request, EntityManagerInterface $entityManager): Response
    {

        $user = $this->getUser();
        $form = $this->createForm(EditCoinAdminType::class, $user);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {

            $user->setCoins(
                $form->get('coin')->getData()
            );
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('message', 'Profil mis à jour !');
            return $this->redirectToRoute('app_user');
        }

        return $this->render('user_coin/editCoin.html.twig', ['form'
        => $form->createView()]);
    }
}
