<?php

namespace App\Controller;

use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
    /**
     * @Route("/", name="home")
     */
    public function index(ProductRepository $repository)
    {
        //On utilise notre propre méthode pour récupérer les nouveautés
        $result = $repository->findNews();
        return $this->render('home/index.html.twig', [
            'new_products' => $result
        ]);
    }
}
