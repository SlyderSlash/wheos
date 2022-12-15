<?php

namespace App\Controller;

use App\Entity\Files;
use App\Entity\Users;
use App\Form\FilesType;
use App\Repository\FilesRepository;
use App\Repository\UsersRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

#[Route('/files')]
class FilesController extends AbstractController
{
    #[Route('/', name: 'app_files_index', methods: ['GET'])]
    public function index(FilesRepository $filesRepository): Response
    {
        return $this->render('files/index.html.twig', [
            'files' => $filesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_files_new', methods: ['GET', 'POST'])]
    public function new(Request $request, FilesRepository $filesRepository, UsersRepository $usersRepository): Response
    {
        $file = new Files();
        $user = $usersRepository->find('user_id_id');
        dd($user);
        $form = $this->createForm(FilesType::class, $file);
        $form->handleRequest($request);
        
        if ($form->isSubmitted() && $form->isValid()) {
            // On RECUPERE les FICHIERS TRANSMIS
            $files = $form->get('files')->getData();
            $file->setPath('/uploads/'.$form->get('name')->getData());
            $file->setUserId($usersRepository);
            dd($file);
            
            // On BOUCLE sur les FICHIERS
            foreach($files as $file){
                // On GENERE un NOUVEAU NOM au FICHIER
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                
                // On COPIE le FICHIER dans le DOSSIER UPLOADS
                $file->move(
                    $this->getParameter('files_directory'),
                    $fileName
                );
                
                // TEST : $file->getPath()->$file;

                // On STOCK le FICHIER dans la BASE DE DONNÉES (son nom)
                $fileUploaded = new Files();
                $fileUploaded->setName($fileName);
                $file->addFiles($fileUploaded);
            }
            $filesRepository->add($file, true);

            return $this->redirectToRoute('app_files_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('files/new.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_files_show', methods: ['GET'])]
    public function show(Files $file): Response
    {
        return $this->render('files/show.html.twig', [
            'file' => $file,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_files_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Files $file, FilesRepository $filesRepository): Response
    {
        $form = $this->createForm(FilesType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            // On RECUPERE les FICHIERS TRANSMIS
            $files = $form->get('files')->getData();
            $file->setPath('/uploads/'.$form->get('name')->getData());
            dd($file);
                        
            // On BOUCLE sur les FICHIERS
            foreach($files as $file){
                // On GENERE un NOUVEAU NOM au FICHIER
                $fileName = md5(uniqid()) . '.' . $file->guessExtension();
                            
                // On COPIE le FICHIER dans le DOSSIER UPLOADS
                $file->move(
                    $this->getParameter('files_directory'),
                    $fileName
                );
                            
                // TEST : $file->getPath()->$file;
            
                // On STOCK le FICHIER dans la BASE DE DONNÉES (son nom)
                $fileUploaded = new Files();
                $fileUploaded->setName($fileName);
                $file->addFiles($fileUploaded);
            }
            $filesRepository->add($file, true);

            return $this->redirectToRoute('app_files_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('files/edit.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_files_delete', methods: ['POST'])]
    public function delete(Request $request, Files $file, FilesRepository $filesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete'.$file->getId(), $request->request->get('_token'))) {
            $filesRepository->remove($file, true);
        }

        return $this->redirectToRoute('app_files_index', [], Response::HTTP_SEE_OTHER);
    }
}
