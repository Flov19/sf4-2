<?php

namespace App\Controller;

use App\Entity\Category;
use App\Repository\CategoryRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category_list")
     */
    public function index(CategoryRepository $repository)
    {
        $category_list =$repository->findAll();
        return $this->render('category/index.html.twig', [
            'category_list' => $category_list,
        ]);
    }


}
