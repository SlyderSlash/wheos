<?php

namespace App\Controller;

use App\Entity\FilesCategories;
use App\Form\FilesCategoriesType;
use App\Repository\FilesCategoriesRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/file/categorie')]
class FileCategorieController extends AbstractController
{
    #[Route('/', name: 'app_file_categorie_index', methods: ['GET'])]
    public function index(FilesCategoriesRepository $filesCategoriesRepository): Response
    {
        return $this->render('file_categorie/index.html.twig', [
            'files_categories' => $filesCategoriesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_file_categorie_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $filesCategory = new FilesCategories();
        $form = $this->createForm(FilesCategoriesType::class, $filesCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->persist($filesCategory);
            $entityManager->flush();

            return $this->redirectToRoute('app_file_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('file_categorie/new.html.twig', [
            'files_category' => $filesCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_file_categorie_show', methods: ['GET'])]
    public function show(FilesCategories $filesCategory): Response
    {
        return $this->render('file_categorie/show.html.twig', [
            'files_category' => $filesCategory,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_file_categorie_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, FilesCategories $filesCategory, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(FilesCategoriesType::class, $filesCategory);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_file_categorie_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('file_categorie/edit.html.twig', [
            'files_category' => $filesCategory,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_file_categorie_delete', methods: ['POST'])]
    public function delete(Request $request, FilesCategories $filesCategory, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$filesCategory->getId(), $request->request->get('_token'))) {
            $entityManager->remove($filesCategory);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_file_categorie_index', [], Response::HTTP_SEE_OTHER);
    }
}
