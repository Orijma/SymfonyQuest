<?php

namespace App\Controller;

use App\Entity\Category;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use App\Entity\Program;

class CategoryController extends AbstractController
{
    /**
     * @Route("/category/", name="category_index")
     */
    public function index(): Response
    {
        $categorys = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findAll();


        return $this->render('category/index.html.twig', [
            'categorys' => $categorys,
        ]);
    }

    /**
     * @Route("/category/{categoryName}", name = "category_show")
     */

     public function show(string $categoryName) 
     {
        $category = $this->getDoctrine()
        ->getRepository(Category::class)
        ->findOneBy(["name" => $categoryName]);
        
    if (!$category) {
        throw $this->createNotFoundException(
            "No category"
        );
    }
    $programs = $this->getDoctrine()
        ->getRepository(Program::class)
        ->findBy(['category' => $category->getId()], ['id' => 'DESC'], 3);
             return $this->render('category/show.html.twig', [
             'programs' => $programs,
        ]);
     }
}
