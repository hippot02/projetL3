<?php

namespace App\Controller\Admin;


use App\Entity\Upload;
use Doctrine\ORM\QueryBuilder;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FieldCollection;
use EasyCorp\Bundle\EasyAdminBundle\Collection\FilterCollection;
use EasyCorp\Bundle\EasyAdminBundle\Config\Crud;
use EasyCorp\Bundle\EasyAdminBundle\Context\AdminContext;
use EasyCorp\Bundle\EasyAdminBundle\Controller\AbstractCrudController;
use EasyCorp\Bundle\EasyAdminBundle\Dto\EntityDto;
use EasyCorp\Bundle\EasyAdminBundle\Dto\SearchDto;
use EasyCorp\Bundle\EasyAdminBundle\Event\AfterEntityBuiltEvent;
use EasyCorp\Bundle\EasyAdminBundle\Field\AssociationField;
use EasyCorp\Bundle\EasyAdminBundle\Field\ImageField;
use EasyCorp\Bundle\EasyAdminBundle\Config\Action;
use EasyCorp\Bundle\EasyAdminBundle\Config\Actions;
use EasyCorp\Bundle\EasyAdminBundle\Field\IntegerField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextareaField;
use EasyCorp\Bundle\EasyAdminBundle\Field\TextField;
use Doctrine\Persistence\ManagerRegistry;
use EasyCorp\Bundle\EasyAdminBundle\Orm\EntityRepository;
use EasyCorp\Bundle\EasyAdminBundle\Router\AdminUrlGenerator;
use Symfony\Component\Filesystem\Filesystem;
use Symfony\Component\Form\Extension\Core\Type\PasswordType;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Response;

class UploadCrudController extends AbstractCrudController
{
    public static function getEntityFqcn(): string
    {
        return Upload::class;
    }

    #[Route('/downloadurl/{filename}/', name: 'downloadfileurl')]
    public function downloadFile($filename, ManagerRegistry $doctrine){

        $product = $doctrine->getRepository(Upload::class)->findOneBy(
            ['files' => $filename]
        );

        if($product->getFilePassword() != null){
            if($_GET['password']){
                if($_GET['password'] == $product->getFilePassword()){
                    $product->setCountDownload($product->getCountDownload() + 1);
                    $doctrine->getManager()->flush();
                    $path = getcwd() . '/uploads/files/' . $filename;
                    $content = file_get_contents($path);

                    $response = new Response();

                    $response->headers->set('Content-Type', 'mime/type');
                    $response->headers->set('Content-Disposition', 'attachment;filename=“' . $filename);

                    $response->setContent($content);
                    return $response;
                }else{
                    return $this->redirectToRoute('download_file', array('id' => $product->getId()));
                }
            }else{
                return $this->redirectToRoute('download_file', array('id' => $product->getId()));
            }
        }else{
            $product->setCountDownload($product->getCountDownload() + 1);
            $doctrine->getManager()->flush();
            $path = getcwd() . '/uploads/files/' . $filename;
            $content = file_get_contents($path);

            $response = new Response();

            $response->headers->set('Content-Type', 'mime/type');
            $response->headers->set('Content-Disposition', 'attachment;filename=' .$filename);

            $response->setContent($content);
            return $response;
        }
    }

    #[Route('/download/{id}', name: 'download_file')]
    public function renderDownlmoad($id , ManagerRegistry $doctrine){
        $entity = $doctrine->getRepository(Upload::class)->find($id);
        $filename = $entity;
        return $this->render(
            'upload/index.html.twig',
            ['filename' => $filename]
        );
    }

    public function createEntity(string $entityFqcn)
    {
        $upload = new Upload();
        $upload->setUser($this->getUser());
        if (!in_array('ROLE_PRIME', $this->getUser()->getRoles()) && !in_array('ROLE_ADMIN', $this->getUser()->getRoles())){
            $this->getUser()->setCoins($this->getUser()->getCoins() - 1);
        }
        return $upload;
    }

    public function configureFields(string $pageName): iterable
    {
        return [
            TextField::new('files', 'File Name')->hideOnForm(),
            IntegerField::new('countDownload', 'Number of Download')->hideOnForm(),
            ImageField::new('files', 'File to upload')->setUploadDir('public/uploads/files')->setUploadedFileNamePattern('[slug]-[uuid].[extension]')->hideOnIndex()->hideWhenUpdating(),
            TextareaField::new('description', 'Description'),
            TextField::new('filePassword', 'Password')->setFormType(PasswordType::class),
            AssociationField::new('User', 'User')->setDisabled()->hideOnForm()->hideOnIndex(),
            AssociationField::new('User', 'User')->setDisabled()->hideOnForm()->setPermission('ROLE_ADMIN'),
        ];
    }

    public function configureActions(Actions $actions): Actions
    {
        $supprimer = Action::new('Supprimer', 'Delete')->setIcon('fas fa-trash-alt')->linkToCrudAction('deleteInfo');
        $download = Action::new('url', 'Download Link')->setIcon('fas fa-download')->linkToCrudAction('getUrl');
        return $actions
            ->update(Crud::PAGE_INDEX, Action::EDIT, function (Action $action) {
                return $action->setIcon('fas fa-edit')->setLabel('Edit');
            })
            ->add(Crud::PAGE_INDEX, $supprimer)
            ->add(Crud::PAGE_INDEX, $download)
            ->disable(Action::DELETE, Action::SAVE_AND_ADD_ANOTHER)

            ->update(Crud::PAGE_NEW, Action::SAVE_AND_RETURN, function (Action $action) {
                return $action->setIcon('fas fa-file')->setLabel('Upload File');
            })
            ->update(Crud::PAGE_INDEX, Action::NEW, function (Action $action) {
                return $action->setIcon('fa fa-file-alt')->setLabel('Add')->linkToCrudAction('manageCoins');
            });
    }

    public function manageCoins(ManagerRegistry $doctrine, AdminUrlGenerator $adminUrlGenerator){
        $user = $this->getUser();
        if($user->getCoins() == 0 && (!in_array('ROLE_PRIME', $this->getUser()->getRoles()) || !in_array('ROLE_ADMIN', $this->getUser()->getRoles()))) {
            return $this->redirectToRoute('upload');
        }else{
            return $this->redirect($adminUrlGenerator->setAction(Action::NEW)->generateUrl());
        }
    }

    public function getUrl(AdminContext  $context , ManagerRegistry $doctrine){
        $product = $context->getRequest()->query->get('entityId');
        $entity = $doctrine->getRepository(Upload::class)->find($product);
        return $this->redirectToRoute('download_file', array('id'=>$entity->getId()));
    }

    public function deleteInfo(AdminContext $context , ManagerRegistry $doctrine){
        $product = $context->getRequest()->query->get('entityId');
        $entity = $doctrine->getRepository(Upload::class)->find($product);
        $filename = $entity->getFiles();
        $filename = getcwd() . '/uploads/files/' . $filename;
        $em = $doctrine->getManager();
        $em->remove($entity);
        $em->flush();
        $filesystem = new Filesystem();
        $filesystem->remove( $filename);
        return $this->redirectToRoute('upload');
    }


    public function createIndexQueryBuilder(SearchDto $searchDto, EntityDto $entityDto, FieldCollection $fields, FilterCollection $filters): QueryBuilder
    {


        if(in_array('ROLE_ADMIN', $this->getUser()->getRoles())){
            $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
            return $response;
        }else{
            $response = $this->container->get(EntityRepository::class)->createQueryBuilder($searchDto, $entityDto, $fields, $filters);
            $response->andWhere('entity.User = :user')->setParameter('user', $this->getUser());
            return $response;
        }

    }

}
