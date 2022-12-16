<?php

namespace App\Controller;

use App\Entity\Files;
use App\Form\FilesType;
use App\Repository\FilesRepository;
use App\Service\CryptingFilesService;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\Mime\Crypto\SMimeEncrypter; // Système de cryptage pour les fichiers ?

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

#[Route('/file/upload')]
class FileUploadController extends AbstractController
{
    #[Route('/', name: 'app_file_upload_index', methods: ['GET'])]
    public function index(FilesRepository $filesRepository): Response
    {
        return $this->render('file_upload/index.html.twig', [
            'files' => $filesRepository->findAll(),
        ]);
    }

    #[Route('/new', name: 'app_file_upload_new', methods: ['GET', 'POST'])]
    // [BUG] Cannot autowire argument $sMimeEncrypter of "App\Controller\FileUploadController::new()": it references class "Symfony\Component\Mime\Crypto\SMimeEncrypter" but no such service exists.
    // [BUG] Same for the dependancies injector : CryptingFileService
    public function new(Request $request, FilesRepository $filesRepository): Response 
    {
        $file = new Files();
        $form = $this->createForm(FilesType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $files = $form->get('file')->getData();
            
            // On GENERE un NOUVEAU NOM au FICHIER
            $fileName = md5(uniqid()) . '.' . $files->guessExtension(); // !IMPORTANT! : SEE if NECESSARY TO SET A NEW NAME after the crypting the files
            $cryptingFilesService = $files;
            $file->setPath('/uploads/' . $fileName);
            // On COPIE le FICHIER dans le DOSSIER UPLOADS
            $files->move(
                $this->getParameter('files_directory'),
                $fileName
            );
            dd($files);
            $cryptingFilesService = $cryptingFilesService->encryptFile($files, $files, $files);

            $filesRepository->add($file, true);
            
            return $this->redirectToRoute('app_file_upload_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('file_upload/new.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_file_upload_show', methods: ['GET'])]
    public function show(Files $file): Response
    {
        return $this->render('file_upload/show.html.twig', [
            'file' => $file,
        ]);
    }

    #[Route('/{id}/edit', name: 'app_file_upload_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Files $file, FilesRepository $filesRepository): Response
    {
        $form = $this->createForm(FilesType::class, $file);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $filesRepository->add($file, true);

            return $this->redirectToRoute('app_file_upload_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->renderForm('file_upload/edit.html.twig', [
            'file' => $file,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_file_upload_delete', methods: ['POST'])]
    public function delete(Request $request, Files $file, FilesRepository $filesRepository): Response
    {
        if ($this->isCsrfTokenValid('delete' . $file->getId(), $request->request->get('_token'))) {
            $filesRepository->remove($file, true);
        }

        return $this->redirectToRoute('app_file_upload_index', [], Response::HTTP_SEE_OTHER);
    }
}
