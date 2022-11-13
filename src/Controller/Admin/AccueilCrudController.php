<?php

namespace App\Controller\Admin;

use App\Entity\Accueil;
use App\Repository\AccueilRepository;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Field\BooleanField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use Symfony\Component\Filesystem\Filesystem;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use Doctrine\Persistence\ManagerRegistry;
use Symfony\Component\Routing\Annotation\Route;

class AccueilCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Accueil::class;
    }


    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('logo', 'Homepage Background')->hideOnForm(),
            ImageField::new('logo', 'Homepage Background')->setUploadDir('public/uploads/background')->setUploadedFileNamePattern('[slug]-[uuid].[extension]')->hideOnIndex()->hideWhenUpdating(),
            TextareaField::new('textOnHome', 'Homepage Text'),
            BooleanField::new('active', 'Active'),
            TextField::new('title', 'Website Name'),
        ];
    }


    public function configureActions(Actions $actions): Actions
    {
        $supprimer = Action::new('Supprimer', 'Delete')->setIcon('fas fa-trash-alt')->linkToCrudAction('deleteInfo');
        return $actions
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fas fa-edit')->setLabel('Edit');
            })
            ->add(Crud::PAGE_INDEX, $supprimer)
            ->disable(Action::DELETE, Action::SAVE_AND_ADD_ANOTHER)

            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setIcon('fas fa-file')->setLabel('Add HomePage');
            })
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Add');
            });
    }

    public function deleteInfo(AdminContext $context, ManagerRegistry $doctrine)
    {
        $product = $context->getRequest()->query->get('entityId');
        $entity = $doctrine->getRepository(Accueil::class)->find($product);
        $filename = $entity->getLogo();
        $filename = getcwd() . '/uploads/background/' . $filename;
        $em = $doctrine->getManager();
        $em->remove($entity);
        $em->flush();
        $filesystem = new Filesystem();
        $filesystem->remove($filename);
        return $this->redirectToRoute('admin');
    }

    #[Route('/', name: 'app_home_page')]
    public function renderDownlmoad(AccueilRepository $accueilRepository)
    {
        $entity = $accueilRepository->getActiveHome(1);
        if ($entity == null) {
            $entity = new Accueil();
        }
        return $this->render(
            'home_page/index.html.twig',
            ['homepageinfo' => $entity]
        );
    }
}
