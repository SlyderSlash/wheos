<?php

namespace App\Controller;

use App\Entity\Categories;
use App\Form\CategoriesType;
use App\Repository\CategoriesRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Doctrine\Form\Type\EntityType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;




#[Route('/admin/categories', name: 'categories_')]
class CategoriesController extends AbstractController
{
    #[Route('/', name: 'home')]
    public function index(CategoriesRepository $categoriesRepository): Response
    {
        return $this->render('admin/categories/index.html.twig', [
            'controller_name' => 'CategoriesController',
            'categories' => $categoriesRepository->findAll(),
        ]);
    }

    #[Route("/add", name: "add")]
    public function addCategory(Request $request,EntityManagerInterface $objectManager)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
    
    
        $category = new Categories;
    
        $form = $this->createFormBuilder($category)
                        ->add('name', options:[
                            'label' => 'Nom',
                        ])

                        ->getForm();
        $form->handleRequest($request);

    
        if ($form->isSubmitted() && $form->isValid()) {
                $category->setParent(null)
                         ->setCreatedAt(new \DateTime());

            $objectManager->persist($category);
            $objectManager->flush();
    
            $this->addFlash('success', 'categorie ajoutée');
            return $this->redirectToRoute('categories_home');
        }
        return $this->render('admin/categories/addCategories.html.twig', [
            'categoryform' => $form->createView(),
        ]);
    }
   
    #[Route("/addSub", name: "addsub")]
    public function addSubCategory(Request $request,EntityManagerInterface $objectManager)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
    
        $category = new Categories;
    
        $form = $this->createFormBuilder($category)
                        ->add('name', options:[
                            'label' => 'Nom',
                        ])
                        ->add('parent',EntityType::class,[
                            'class' => Categories::class,
                            'choice_label' => 'name',
                            'group_by' => 'parent.name',
                            'query_builder' => function(CategoriesRepository $cr){
                                return $cr->createQueryBuilder('c')
                                            ->where('c.parent IS NULL')
                                            ->orderBy('c.name','ASC');
                            }
                          ])                        

                        ->getForm();
        $form->handleRequest($request);

    
        if ($form->isSubmitted() && $form->isValid()) {
    
            $category->setCreatedAt(new \DateTime());

            $objectManager->persist($category);
            $objectManager->flush();
    
            $this->addFlash('success', 'sous categorie ajoutée');
            return $this->redirectToRoute('categories_home');
        }
        return $this->render('admin/categories/addSubCategorie.html.twig', [
            'categoryform' => $form->createView(),
        ]);
    }
    
    #[Route("/edit/{id}", name: "edit")]
    public function editCategory(Categories $categories, Request $request,EntityManagerInterface $objectManager)
    {
        $this->denyAccessUnlessGranted('ROLE_ADMIN');
    
        $form = $this->createForm(CategoriesType::class, $categories);
        $form->handleRequest($request);
    
        if ($form->isSubmitted() && $form->isValid()) {  
            $objectManager->persist($categories);
            $objectManager->flush();
    
            $this->addFlash('success', 'categorie modifiée');
            return $this->redirectToRoute('categories_home');
        }
    
        return $this->render('admin/categories/editCategories.html.twig', [
            'categoriesForm' => $form->createView(),
        ]);
    }
}





