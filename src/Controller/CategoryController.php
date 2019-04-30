<?php

namespace App\Controller;

use App\Repository\CategoryRepository;
//use App\Repository\ProductRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category", name="category")
     */
    public function index()
    {
        return $this->render('category/index.html.twig.', [
            'controller_name' => 'CategoryController',
        ]);
    }

    /**
     * @Route("/category/{id}", name="category_show")
     */
    public function show($id, CategoryRepository $categoryRepository)
    {

            $category = $categoryRepository->find($id);

                return $this->render('category/show.html.twig', [
            'category ' => $category ,
        ]);
    }
}
