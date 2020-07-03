<?php

namespace App\Controller;

use App\Entity\Category;
use App\Form\ConfirmDeletionFormType;
use App\Repository\CategoryRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use App\Form\CategoryFormType;
use Symfony\Component\Form\FormAbstractType;

/**
 * @IsGranted("ROLE_ADMIN")
 * @Route("/admin/category",  name="admin_category_")
 */

class AdminCategoryController extends AbstractController
{
    /**
     * @Route("", name="list")
     */
    public function index(CategoryRepository $repository)
    {
        $categories = $repository->findAll();
        return $this->render('admin_category/index.html.twig', [
            'category_list' => $categories,
        ]);
    }

    /**
     * @Route("/new", name="add")
     */
    public function add(Request $request, EntityManagerInterface $entityManager){
        $form = $this->createForm(CategoryFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $category = $form->getData();
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'La catégorie a été enregistrer');
            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render('admin_category/add.html.twig', [
            'category_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/edit", name="edit")
     */
    public function edit(Category $category, Request $request, EntityManagerInterface $entityManager){
        $form = $this->createForm(CategoryFormType::class, $category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $entityManager->flush();
            $this->addFlash('success', 'Modifications enregistrées');
            return $this->redirectToRoute('admin_category_list');
        }

        return $this->render('admin_category/edit.html.twig', [
            'category' => $category,
            'category_form' => $form->createView()
        ]);
    }

    /**
     * @Route("/{id}/delete", name="delete")
     */
    public function delete(Category $category, Request $request, EntityManagerInterface $entityManager){
        $form = $this->createForm(ConfirmDeletionFormType::class);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            //A l'inverse de persist(), remove() prépare à la suppression d'une entité
            $entityManager->remove($category);
            $entityManager->flush();

            $this->addFlash('success', 'Le produit a été supprimmé');
            return $this->redirectToRoute('admin_category_list');
        }
        return $this->render('admin_category/delete.html.twig', [
            'category' => $category,
            'deletion_form' => $form->createView()
        ]);
    }
}
