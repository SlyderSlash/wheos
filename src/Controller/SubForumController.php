<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Repository\CategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/forum', name: 'forum_')]
class SubForumController extends AbstractController
{
    #[Route('/{id}', name: 'subforum')]
    public function index(Categories $category,CategoriesRepository $categoriesRepository,$id): Response
    {
        $subCategories = $categoriesRepository->findBySubCategories();
        return $this->render('forum/subForum.html.twig',compact('category','subCategories'));
    }
}
