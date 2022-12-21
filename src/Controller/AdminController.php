<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Entity\Users;
use App\Form\CategoriesType;
use App\Form\EditUserType;
use App\Repository\CategoriesRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(): Response
    {
        return $this->render('admin/index.html.twig', [
            'controller_name' => 'AdminController',
        ]);
    }

    #[Route("/utilisateurs", name: "utilisateurs")]
    public function usersList(UsersRepository $users)
    {
        return $this->render('admin/users.html.twig', [
            'users' => $users->findAll(),
        ]);
    }

    #[Route("/utilisateurs/modifier/{id}", name: "modifier_utilisateur")]
    public function editUser(Users $user, Request $request)
    {
        $form = $this->createForm(EditUserType::class, $user);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this-> ManagerRegistry::getManager();   
            $entityManager->persist($user);
            $entityManager->flush();

            $this->addFlash('success', 'Utilisateur modifié');
            return $this->redirectToRoute('utilisateurs');
        }
        
        return $this->render('admin/edituser.html.twig', [
            'userForm' => $form->createView(),
        ]);
    }

    #[Route("/categories", name: "Categories")]
    public function showCategory(CategoriesRepository $categoriesRepository)
    {
        return $this->render('admin/categories/categories.html.twig', [
            'categories' => $categoriesRepository->findAll(),
        ]);
    }


    #[Route("/categories/add", name: "addCategory")]
    public function addCategory(Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');


        $category = new Categories;

        $form = $this->createForm(CategoriesType::class,$category);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this-> ManagerRegistry::getManager();   
            $entityManager->persist($category);
            $entityManager->flush();

            $this->addFlash('success', 'categorie ajoutée');
            return $this->redirectToRoute('categories');
        }
        return $this->render('admin/categories/addCategories.html.twig', [
            'categoryform' => $form->createView(),
        ]);
    }


    #[Route("/categories/edit/{id}", name: "editCategory")]
    public function editCategory(Categories $categories, Request $request)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');

        $form = $this->createForm(CategoriesType::class, $categories);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager = $this-> ManagerRegistry::getManager();   
            $entityManager->persist($categories);
            $entityManager->flush();

            $this->addFlash('success', 'categorie modifiée');
            return $this->redirectToRoute('categories');
        }


        return $this->render('admin/categories/editCategories.html.twig', [
            'categoriesForm' => $form->createView(),
        ]);
    }
}
