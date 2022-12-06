<?php

namespace App\Controller;

use App\Repository\CategoriesRepository;
use App\Repository\ForumsRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class ForumController extends AbstractController
{
    #[Route('/forum', name: 'app_forum')]
    public function home(CategoriesRepository $categoriesRepository,$id): Response
    {
        $subCategories = $categoriesRepository -> findBySubCategories($id);

        return $this->render('forum/home.html.twig', [
            'controller_name' => 'ForumController',
            'categories' => $categoriesRepository->findBy(['parent' => Null], ['id' => 'asc']),
            'subCat' => $subCategories
        ]);
    }
}
