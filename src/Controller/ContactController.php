<?php

namespace App\Controller;

use App\Entity\Contact;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\EmailType;

class ContactController extends AbstractController
{
    #[Route('/contact', name: 'app_contact')]
    public function new(Request $request, ManagerRegistry $doctrine): Response
    {
        // creates a task object and initializes some data for this example
        $contact = new Contact();
        $contact->setMessage('');
        $contact->setMail('');
        $contact->setUsername('');



        $form = $this->createFormBuilder($contact)
            ->add('message', TextType::class)
            ->add('mail', EmailType::class)
            ->add('username', TextType::class)
            ->add('save', SubmitType::class, ['label' => 'Envoyer Message'])
            ->getForm();

        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $contactManager = $doctrine->getManager();
            $contactManager->persist($contact);
            $contactManager->flush();
            return $this->redirectToRoute('app_home_page');
        }



        return $this->renderForm('contact/index.html.twig', [
            'form' => $form,
        ]);
    }
    // #[Route('/contact', name: 'app_contact')]
    public function index(): Response
    {
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
        ]);
    }
}
